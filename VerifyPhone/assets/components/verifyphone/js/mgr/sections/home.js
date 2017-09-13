VerifyPhone.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'verifyphone-panel-home',
            renderTo: 'verifyphone-panel-home-div'
        }]
    });
    VerifyPhone.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(VerifyPhone.page.Home, MODx.Component);
Ext.reg('verifyphone-page-home', VerifyPhone.page.Home);