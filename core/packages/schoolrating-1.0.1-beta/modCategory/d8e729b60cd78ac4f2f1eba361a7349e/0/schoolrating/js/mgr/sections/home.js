SchoolRating.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'schoolrating-panel-home',
            renderTo: 'schoolrating-panel-home-div'
        }]
    });
    SchoolRating.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.page.Home, MODx.Component);
Ext.reg('schoolrating-page-home', SchoolRating.page.Home);