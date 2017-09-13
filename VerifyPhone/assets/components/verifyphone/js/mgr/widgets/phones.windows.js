VerifyPhone.window.CreatePhone = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'verifyphone-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('verifyphone_item_create'),
        width: 550,
        autoHeight: true,
        url: VerifyPhone.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    VerifyPhone.window.CreatePhone.superclass.constructor.call(this, config);
};
Ext.extend(VerifyPhone.window.CreatePhone, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('verifyphone_item_name'),
            name: 'phone',
            id: config.id + '-phone',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('verifyphone_item_description'),
            name: 'code',
            id: config.id + '-code',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('verifyphone_item_active'),
            name: 'verified',
            id: config.id + '-verified',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('verifyphone-item-window-create', VerifyPhone.window.CreatePhone);


VerifyPhone.window.UpdatePhone = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'verifyphone-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('verifyphone_item_update'),
        width: 550,
        autoHeight: true,
        url: VerifyPhone.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    VerifyPhone.window.UpdatePhone.superclass.constructor.call(this, config);
};
Ext.extend(VerifyPhone.window.UpdatePhone, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('verifyphone_item_name'),
            name: 'phone',
            id: config.id + '-phone',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('verifyphone_item_description'),
            name: 'code',
            id: config.id + '-code',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('verifyphone_item_active'),
            name: 'verified',
            id: config.id + '-verified',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('verifyphone-item-window-update', VerifyPhone.window.UpdatePhone);