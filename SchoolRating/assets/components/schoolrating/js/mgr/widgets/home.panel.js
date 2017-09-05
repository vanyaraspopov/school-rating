SchoolRating.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'schoolrating-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('schoolrating') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('schoolrating_activities'),
                layout: 'anchor',
                items: [{
                    html: _('schoolrating_activities_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'schoolrating-grid-activities',
                    cls: 'main-wrapper',
                }]
            }, {
                title: _('schoolrating_sections'),
                layout: 'anchor',
                items: [{
                    html: _('schoolrating_sections_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'schoolrating-grid-sections',
                    cls: 'main-wrapper',
                }]
            }, {
                title: _('schoolrating_coefficients'),
                layout: 'anchor',
                items: [{
                    html: _('schoolrating_coefficients_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'schoolrating-grid-coefficients',
                    cls: 'main-wrapper',
                }]
            }, {
                title: _('schoolrating_rating'),
                layout: 'anchor',
                items: [{
                    html: _('schoolrating_rating_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'schoolrating-grid-rating',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    SchoolRating.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.panel.Home, MODx.Panel);
Ext.reg('schoolrating-panel-home', SchoolRating.panel.Home);
