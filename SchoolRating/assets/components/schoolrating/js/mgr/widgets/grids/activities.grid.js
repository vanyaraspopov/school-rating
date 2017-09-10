SchoolRating.grid.Activities = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-grid-activities';
    }
    Ext.applyIf(config, {
        url: SchoolRating.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/activity/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateActivity(grid, e, row);
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
    SchoolRating.grid.Activities.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(SchoolRating.grid.Activities, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = SchoolRating.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    createActivity: function (btn, e) {
        var w = MODx.load({
            xtype: 'schoolrating-activity-window-create',
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

    updateActivity: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;
        var contentid = this.menu.record.contentid;

        window.open('?a=resource/update&id=' + contentid, '_blank');
    },

    removeActivity: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('schoolrating_activities_remove')
                : _('schoolrating_activity_remove'),
            text: ids.length > 1
                ? _('schoolrating_activities_remove_confirm')
                : _('schoolrating_activity_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/activity/remove',
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
        return ['id', 'contentid', 'pagetitle', 'section', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('id'),
            dataIndex: 'id',
            hidden: true,
            sortable: true,
            width: 70
        }, {
            header: _('schoolrating_activity_resource_id'),
            dataIndex: 'contentid',
            sortable: true,
            width: 70,
            renderer: function (value) {
                return '<a href="?a=resource/update&id=' +value+ '" target="_blank">' +value+ '</a>';
            }
        }, {
            header: _('schoolrating_activity_name'),
            dataIndex: 'pagetitle',
            sortable: true,
            width: 200,
        }, {
            header: _('schoolrating_section'),
            dataIndex: 'section',
            sortable: true,
            width: 200,
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
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('schoolrating_activity_create'),
            handler: function () {
                MODx.msg.alert(
                    _('schoolrating_activity_create'),
                    _('schoolrating_activity_create_help')
                );
            },//this.createActivity,
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
Ext.reg('schoolrating-grid-activities', SchoolRating.grid.Activities);
