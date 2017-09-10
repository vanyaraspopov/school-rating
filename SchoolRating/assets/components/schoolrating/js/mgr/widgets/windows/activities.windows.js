SchoolRating.window.CreateActivity = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-activity-window-create';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_activity_create'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: 'mgr/activity/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.CreateActivity.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.CreateActivity, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('schoolrating_activity_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-activity-window-create', SchoolRating.window.CreateActivity);


SchoolRating.window.UpdateActivityParticipant = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-activity-window-update';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_activities_participants_update'),
        width: 650,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: '',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.UpdateActivityParticipant.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.UpdateActivityParticipant, MODx.Window, {

    getFields: function (config) {
        return {
            title: _('schoolrating_activities_participants'),
            xtype: 'schoolrating-grid-activities-participants',
            record: config.record.object
        };
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-activity-window-update', SchoolRating.window.UpdateActivityParticipant);