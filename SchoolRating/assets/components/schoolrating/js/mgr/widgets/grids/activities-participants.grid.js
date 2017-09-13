SchoolRating.grid.ActivitiesParticipants = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-grid-activities-participants';
    }
    Ext.applyIf(config, {
        url: SchoolRating.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/activity/getparticipants',
            resource_id: config.record.id
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
        autosave: true,
        save_action: 'mgr/activity/updateparticipantsfromgrid'
    });
    SchoolRating.grid.ActivitiesParticipants.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(SchoolRating.grid.ActivitiesParticipants, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var m = [];
        m.push({
            text: _('schoolrating_activity_participant_remove')
            , handler: this.removeActivityParticipant
        });
        this.addContextMenuItem(m);
    },

    removeActivityParticipant: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('schoolrating_activity_participant_remove')
                : _('schoolrating_activity_participant_remove'),
            text: ids.length > 1
                ? _('schoolrating_activity_participant_remove_confirm')
                : _('schoolrating_activity_participant_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/activity/removeparticipant',
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
        return ['id', 'user_id', 'activity_id', 'allowed'];
    },

    getColumns: function () {
        return [{
            header: _('schoolrating_activity_participant_id'),
            dataIndex: 'id',
            sortable: true,
            width: 70
        }, {
            header: _('schoolrating_activity_participant_user_id'),
            dataIndex: 'user_id',
            sortable: true,
            editor: { xtype: 'textfield' },
            width: 200,
        }, {
            header: _('schoolrating_activity_participant_resource_id'),
            dataIndex: 'resource_id',
            sortable: true,
            editor: { xtype: 'textfield' },
            width: 200,
        }, {
            header: _('schoolrating_activity_participant_allowed'),
            dataIndex: 'allowed',
            sortable: true,
            editor: { xtype: 'combo-boolean' },
            renderer: this.renderBoolean,
            width: 100,
        }];
    },

    getTopBar: function () {
        return [];
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

    renderBoolean: function(val,cell,row) {
        return val == '' || val == 0
            ? '<span style="color:red">' + _('no') + '<span>'
            : '<span style="color:green">' + _('yes') + '<span>';
    }
});
Ext.reg('schoolrating-grid-activities-participants', SchoolRating.grid.ActivitiesParticipants);
