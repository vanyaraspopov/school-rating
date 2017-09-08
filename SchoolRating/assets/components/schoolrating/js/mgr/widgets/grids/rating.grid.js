SchoolRating.grid.Rating = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-grid-rating';
    }
    Ext.applyIf(config, {
        url: SchoolRating.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/rating/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateRating(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                /*return !rec.data.active
                 ? 'schoolrating-grid-row-disabled'
                 : '';*/
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    SchoolRating.grid.Rating.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(SchoolRating.grid.Rating, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = SchoolRating.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    createRating: function (btn, e) {
        var w = MODx.load({
            xtype: 'schoolrating-rating-window-create',
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

    updateRating: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/rating/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'schoolrating-rating-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeRating: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('schoolrating_rating_remove')
                : _('schoolrating_rating_remove'),
            text: ids.length > 1
                ? _('schoolrating_rating_remove_confirm')
                : _('schoolrating_rating_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/rating/remove',
                ids: Ext.util.JSON.encode(ids),
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

    getFields: function () {
        return ['id', 'user_id', 'name', 'date', 'section', 'rating', 'comment', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('schoolrating_rating_id'),
            dataIndex: 'id',
            hidden: true,
            sortable: true,
            width: 70
        }, {
            header: _('schoolrating_rating_user_id'),
            dataIndex: 'user_id',
            sortable: true,
            hidden: true,
            width: 200,
        }, {
            header: _('username'),
            dataIndex: 'name',
            sortable: false,
            width: 250,
        }, {
            header: _('schoolrating_rating_date'),
            dataIndex: 'date',
            sortable: false,
            width: 250,
        }, {
            header: _('schoolrating_section'),
            dataIndex: 'section',
            sortable: false,
            width: 250,
        }, {
            header: _('schoolrating_rating_rating'),
            dataIndex: 'rating',
            sortable: false,
            width: 250,
        }, {
            header: _('schoolrating_rating_comment'),
            dataIndex: 'comment',
            sortable: false,
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
Ext.reg('schoolrating-grid-rating', SchoolRating.grid.Rating);
