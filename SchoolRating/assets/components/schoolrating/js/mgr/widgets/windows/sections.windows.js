SchoolRating.window.CreateSection = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-section-window-create';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_section_create'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: 'mgr/section/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.CreateSection.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.CreateSection, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('schoolrating_section_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'modx-combo-usergroup',
            fieldLabel: _('schoolrating_section_usergroup_id'),
            name: 'usergroup_id',
            hiddenName: 'usergroup_id',
            id: config.id + '-usergroup_id',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('schoolrating_coefficient_css_class'),
            description: _('schoolrating_coefficient_css_class_help'),
            name: 'css_class',
            id: config.id + '-css_class',
            anchor: '99%',
            allowBlank: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-section-window-create', SchoolRating.window.CreateSection);


SchoolRating.window.UpdateSection = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-section-window-update';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_section_update'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: 'mgr/section/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.UpdateSection.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.UpdateSection, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('schoolrating_section_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'modx-combo-usergroup',
            fieldLabel: _('schoolrating_section_usergroup_id'),
            name: 'usergroup_id',
            hiddenName: 'usergroup_id',
            id: config.id + '-usergroup_id',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('schoolrating_coefficient_css_class'),
            description: _('schoolrating_coefficient_css_class_help'),
            name: 'css_class',
            id: config.id + '-css_class',
            anchor: '99%',
            allowBlank: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-section-window-update', SchoolRating.window.UpdateSection);