UserExtra.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'userextra-panel-home',
            renderTo: 'userextra-panel-home-div'
        }]
    });
    UserExtra.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(UserExtra.page.Home, MODx.Component);
Ext.reg('userextra-page-home', UserExtra.page.Home);