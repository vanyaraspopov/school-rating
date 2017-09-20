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