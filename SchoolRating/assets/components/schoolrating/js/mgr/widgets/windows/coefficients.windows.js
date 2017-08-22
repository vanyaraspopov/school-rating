SchoolRating.window.CreateCoefficient = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-coefficient-window-create';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_coefficient_create'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: 'mgr/coefficient/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.CreateCoefficient.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.CreateCoefficient, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('schoolrating_coefficient_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'numberfield',
            fieldLabel: _('schoolrating_coefficient_value'),
            name: 'value',
            id: config.id + '-value',
            anchor: '99%'
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-coefficient-window-create', SchoolRating.window.CreateCoefficient);


SchoolRating.window.UpdateCoefficient = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-coefficient-window-update';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_coefficient_update'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: 'mgr/coefficient/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.UpdateCoefficient.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.UpdateCoefficient, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('schoolrating_coefficient_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'numberfield',
            fieldLabel: _('schoolrating_coefficient_value'),
            name: 'value',
            id: config.id + '-value',
            anchor: '99%',
            allowBlank: false,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-coefficient-window-update', SchoolRating.window.UpdateCoefficient);