SchoolRating.grid.Users = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-grid-users';
    }

    this.sm = new Ext.grid.CheckboxSelectionModel();
    this.cm = new Ext.grid.ColumnModel({
        columns: this.getColumns(config)
    });

    Ext.applyIf(config, {
        url: SchoolRating.config.connector_url,
        fields: this.getFields(config),
        tbar: this.getTopBar(config),
        cm: this.cm,
        sm: this.sm,
        baseParams: {
            action: 'mgr/rating/users'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.viewRating(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'schoolrating-grid-row-disabled'
                    : '';
            }
        },
        paging: true,
        remoteSort: false,
        autoHeight: true,
    });
    SchoolRating.grid.Users.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(SchoolRating.grid.Users, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = SchoolRating.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    getFields: function () {
        return ['id', 'username', 'fullname', 'rating', 'active', 'actions'];
    },

    getColumns: function () {
        return [this.sm, {
            header: _('id'),
            dataIndex: 'id',
            hidden: false,
            sortable: true,
            width: 70
        }, {
            header: _('username'),
            dataIndex: 'username',
            sortable: true,
            width: 250,
        }, {
            header: _('username'),
            dataIndex: 'fullname',
            sortable: true,
            width: 250,
        }, {
            header: _('schoolrating_rating_rating'),
            dataIndex: 'rating',
            sortable: true,
            width: 250,
        }, {
            header: _('schoolrating_grid_actions'),
            dataIndex: 'actions',
            renderer: SchoolRating.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('schoolrating_rating_create'),
            handler: this.createRating,
            scope: this
        }, {
            text: '<i class="icon icon-calendar"></i>&nbsp;' + _('schoolrating_rating_reports'),
            handler: this.viewReports,
            scope: this
        }, {
            text: '<i class="icon icon-edit"></i>&nbsp;' + _('schoolrating_rating_recalculate_all'),
            cls: 'primary-button',
            handler: this.recalculateAll,
            scope: this
        }, '->', {
            xtype: 'schoolrating-field-search',
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

    createRating: function (btn, e) {
        var cs = this.getSelectedAsList();
        if (cs === false) {
            MODx.msg.alert(
                _('schoolrating_rating_create'),
                _('schoolrating_rating_create_err_nc')
            );
            return false;
        }

        var w = MODx.load({
            xtype: 'schoolrating-rating-window-create',
            id: Ext.id(),
            params: {
                user_ids: cs
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({active: true});
        w.show(e.target);
    },

    recalculateAll: function (btn, e) {
        MODx.msg.confirm({
            title: _('schoolrating_rating_recalculate_all'),
            text: _('schoolrating_rating_recalculate_all'),
            url: this.config.url,
            params: {
                action: 'mgr/rating/recalculateAll'
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    viewRating: function (grid, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        var w = MODx.load({
            xtype: 'schoolrating-rating-window',
            id: Ext.id(),
            params: {
                user_id: id
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({active: true});
        w.show(e.target);
    },

    viewReports: function (grid, e) {
        var w = MODx.load({
            xtype: 'schoolrating-reports-window',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({active: true});
        w.show(e.target);
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
Ext.reg('schoolrating-grid-users', SchoolRating.grid.Users);
