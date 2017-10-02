SchoolRating.page.Logs = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'schoolrating-panel-logs',
            renderTo: 'schoolrating-panel-home-div'
        }]
    });
    SchoolRating.page.Logs.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.page.Logs, MODx.Component);
Ext.reg('schoolrating-page-logs', SchoolRating.page.Logs);