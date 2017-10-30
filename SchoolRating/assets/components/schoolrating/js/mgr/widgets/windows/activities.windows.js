SchoolRating.window.UpdateActivityParticipant = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-activity-window-update';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_activities_participants'),
        width: 700,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: '',
        buttons: [{
            text: _('close')
            ,scope: this
            ,handler: function() { config.closeAction !== 'close' ? this.hide() : this.close(); }
        }],
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

SchoolRating.window.EmailActivityParticipant = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-activity-window-email';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_activities_participants_email'),
        width: 700,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        baseParams: {
            action: 'mgr/participant/emailmultiple',
            ids: config.params.ids,
            resource_id: config.params.resource_id
        },
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.EmailActivityParticipant.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.EmailActivityParticipant, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('schoolrating_activities_participants_email_subject'),
            name: 'subject',
            id: config.id + '-subject',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'textarea',
            height: 400,
            fieldLabel: _('schoolrating_activities_participants_email_text'),
            name: 'text',
            id: config.id + '-text',
            anchor: '99%',
            allowBlank: false,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-activity-window-email', SchoolRating.window.EmailActivityParticipant);