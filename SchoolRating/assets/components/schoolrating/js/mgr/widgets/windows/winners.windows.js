SchoolRating.window.Winners = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-winners-window';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_winners'),
        width: 700,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        action: '',
        buttons: [{
            text: _('close')
            , scope: this
            , handler: function () {
                config.closeAction !== 'close' ? this.hide() : this.close();
            }
        }],
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.Winners.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.Winners, MODx.Window, {

    getFields: function (config) {
        return {
            title: _('schoolrating_winners'),
            xtype: 'schoolrating-grid-winners',
            baseParams: {
                action: 'mgr/winner/getlist',
                resource_id: config.record.object.id
            }
        };
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-winners-window', SchoolRating.window.Winners);

SchoolRating.window.CreateWinner = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-winners-window-create';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_winner_create'),
        width: 550,
        autoHeight: true,
        url: SchoolRating.config.connector_url,
        baseParams: {
            action: 'mgr/winner/create',
            resource_id: config.params.resource_id
        },
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.CreateWinner.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.CreateWinner, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'modx-combo-user',
            fieldLabel: _('user'),
            hiddenName: 'user_id',
            name: 'user_id',
            id: config.id + '-user_id',
            anchor: '99%',
            allowBlank: false,
            baseParams: {
                action: 'security/user/getlist',
                usergroup: SchoolRating.config['usergroupUsers']
            }
        }, {
            xtype: 'numberfield',
            fieldLabel: _('schoolrating_winner_place'),
            name: 'value',
            id: config.id + '-value',
            anchor: '99%',
            allowBlank: false
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-winners-window-create', SchoolRating.window.CreateWinner);