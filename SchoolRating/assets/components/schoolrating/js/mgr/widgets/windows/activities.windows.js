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


SchoolRating.window.UpdateActivity = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-activity-window-update';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_activity_update'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: 'mgr/activity/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.UpdateActivity.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.UpdateActivity, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('schoolrating_activity_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'numberfield',
            fieldLabel: _('schoolrating_activity_value'),
            name: 'value',
            id: config.id + '-value',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('schoolrating_activity_css_class'),
            description: _('schoolrating_activity_css_class_help'),
            name: 'css_class',
            id: config.id + '-css_class',
            anchor: '99%',
            allowBlank: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-activity-window-update', SchoolRating.window.UpdateActivity);