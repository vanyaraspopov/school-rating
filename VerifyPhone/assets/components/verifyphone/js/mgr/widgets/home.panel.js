VerifyPhone.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'verifyphone-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('verifyphone') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('verifyphone_items'),
                layout: 'anchor',
                items: [{
                    html: _('verifyphone_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'verifyphone-grid-phones',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    VerifyPhone.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(VerifyPhone.panel.Home, MODx.Panel);
Ext.reg('verifyphone-panel-home', VerifyPhone.panel.Home);
