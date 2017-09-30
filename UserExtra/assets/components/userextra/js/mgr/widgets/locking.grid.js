UserExtra.grid.Locking = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'userextra-grid-locking';
    }
    Ext.applyIf(config, {
        url: UserExtra.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/item/getlist'
        },
        listeners: {
            /*rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateItem(grid, e, row);
            }*/
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'userextra-grid-row-disabled'
                    : '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
        autosave: true,
        save_action: 'mgr/item/updatefromgrid'
    });
    UserExtra.grid.Locking.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(UserExtra.grid.Locking, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = UserExtra.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    lockUser: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/item/lock',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    unlockUser: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/item/unlock',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    notifyUserLocked: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/item/notify',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function (response) {
                        MODx.msg.alert(
                            _('success'),
                            response.message
                        );
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(
                            _('error'),
                            response.message
                        );
                    }, scope: this
                }
            }
        })
    },

    getFields: function () {
        return ['id', 'username', 'active', 'blocked', 'locking_expire', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('userextra_item_id'),
            dataIndex: 'id',
            sortable: true,
            width: 70
        }, {
            header: _('username'),
            dataIndex: 'username',
            sortable: true,
            width: 200,
        }, {
            header: _('userextra_locking_locked'),
            dataIndex: 'blocked',
            renderer: UserExtra.utils.renderBlocked,
            sortable: false,
            width: 250,
        }, {
            header: _('userextra_locking_expire'),
            dataIndex: 'locking_expire',
            editor: new Ext.form.DateField({
                disabled : false,
                format: 'd.m.Y'
            }),
            renderer: function (value, props, row) {
                if (value) {
                    return Ext.util.Format.date(value, 'd.m.Y');
                } else {
                    return '&ndash;';
                }
            },
            sortable: false,
            width: 250,
        }, {
            header: _('userextra_grid_actions'),
            dataIndex: 'actions',
            renderer: UserExtra.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return ['->', {
            xtype: 'userextra-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg('userextra-grid-locking', UserExtra.grid.Locking);
