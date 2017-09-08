SchoolRating.window.CreateRating = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-rating-window-create';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_rating_create'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: 'mgr/rating/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.CreateRating.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.CreateRating, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'modx-combo-user',
            fieldLabel: _('user'),
            name: 'user_id',
            hiddenName: 'user_id',
            id: config.id + '-user_id',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'schoolrating-combo-section',
            fieldLabel: _('schoolrating_section'),
            name: 'section_id',
            id: config.id + '-section_id',
            anchor: '99%',
        }, {
            xtype: 'numberfield',
            fieldLabel: _('schoolrating_rating_rating'),
            name: 'rating',
            id: config.id + '-rating',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('schoolrating_rating_comment'),
            name: 'comment',
            id: config.id + '-comment',
            anchor: '99%',
            allowBlank: false,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-rating-window-create', SchoolRating.window.CreateRating);


SchoolRating.window.UpdateRating = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-rating-window-update';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_rating_update'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: 'mgr/rating/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.UpdateRating.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.UpdateRating, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('schoolrating_rating_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'numberfield',
            fieldLabel: _('schoolrating_rating_value'),
            name: 'value',
            id: config.id + '-value',
            anchor: '99%',
            allowBlank: false,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-rating-window-update', SchoolRating.window.UpdateRating);