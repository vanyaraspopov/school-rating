SchoolRating.panel.Logs = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'schoolrating-panel-logs',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('schoolrating_log') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: this.getTabs()
        }]
    });
    SchoolRating.panel.Logs.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.panel.Logs, MODx.Panel, {

    getTabs: function () {
        var tabs = [];
        tabs.push({
            title: _('schoolrating_logs'),
            layout: 'anchor',
            items: [{
                html: _('schoolrating_logs_intro_msg'),
                cls: 'panel-desc',
            }, {
                xtype: 'schoolrating-grid-logs',
                cls: 'main-wrapper',
            }]
        });
        return tabs;
    }

});
Ext.reg('schoolrating-panel-logs', SchoolRating.panel.Logs);
