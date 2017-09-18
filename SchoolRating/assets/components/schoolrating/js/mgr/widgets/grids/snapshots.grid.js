SchoolRating.grid.Snapshots = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-grid-snapshots';
    }
    Ext.applyIf(config, {
        url: SchoolRating.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        baseParams: {
            action: 'mgr/snapshot/getlist',
        },
        listeners: {
            /*rowDblClick: function (grid, rowIndex, e) {
             var row = grid.store.getAt(rowIndex);
             this.updateActivityParticipant(grid, e, row);
             },*/
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
        //autosave: true,
        //save_action: 'mgr/participant/updatefromgrid'
    });
    SchoolRating.grid.Snapshots.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(SchoolRating.grid.Snapshots, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var m = [];
        m.push({
            text: _('schoolrating_snapshot_remove')
            , handler: this.removeActivityParticipant
        });
        this.addContextMenuItem(m);
    },

    getFields: function () {
        return ['id', 'date', 'filepath', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('id'),
            dataIndex: 'id',
            sortable: true,
            width: 70
        }, {
            header: _('schoolrating_snapshot_date'),
            dataIndex: 'date',
            renderer: SchoolRating.utils.renderDate,
            sortable: true,
            width: 200,
        }, {
            header: _('schoolrating_snapshot_filepath'),
            dataIndex: 'filepath',
            sortable: true,
            width: 300,
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
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('schoolrating_snapshot_create'),
            handler: this.createSnapshot,
            scope: this
        }, {
            text: '<i class="icon icon-upload"></i>&nbsp;' + _('schoolrating_snapshot_upload'),
            handler: this.uploadSnapshot,
            scope: this
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

    createSnapshot: function () {
        MODx.msg.confirm({
            title: _('schoolrating_snapshot_create'),
            text: _('schoolrating_snapshot_create_help'),
            url: this.config.url,
            params: {
                action: 'mgr/snapshot/create',
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

    uploadSnapshot: function (btn, e) {
        var w = MODx.load({
            xtype: 'schoolrating-snapshots-window-upload',
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

    downloadSnapshot: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;
        var filepath = this.menu.record.filepath;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/snapshot/download',
                file: filepath
            },
            listeners: {
                'success':{fn:function(r) {
                    if (!Ext.isEmpty(r.object.url)) {
                        location.href = MODx.config.connector_url+'?action=browser/file/download&download=1&file='+filepath+'&HTTP_MODAUTH='+MODx.siteId+'&source='+this.config.source || 1+'&wctx='+MODx.ctx;
                    }
                },scope:this}
            }
        });
    },

    removeSnapshot: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('schoolrating_snapshots_remove')
                : _('schoolrating_snapshot_remove'),
            text: ids.length > 1
                ? _('schoolrating_snapshots_remove_confirm')
                : _('schoolrating_snapshot_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/snapshot/remove',
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

    renderBoolean: function(val,cell,row) {
        return val == '' || val == 0
            ? '<span style="color:red">' + _('no') + '<span>'
            : '<span style="color:green">' + _('yes') + '<span>';
    }
});
Ext.reg('schoolrating-grid-snapshots', SchoolRating.grid.Snapshots);
