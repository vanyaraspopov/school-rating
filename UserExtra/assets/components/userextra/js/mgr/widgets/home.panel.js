UserExtra.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'userextra-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('userextra') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('userextra_personal_data'),
                layout: 'anchor',
                items: [{
                    html: _('userextra_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'userextra-grid-items',
                    cls: 'main-wrapper',
                }]
            }, {
                title: _('userextra_locking'),
                layout: 'anchor',
                items: [{
                    html: _('userextra_locking_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'userextra-grid-locking',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    UserExtra.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(UserExtra.panel.Home, MODx.Panel);
Ext.reg('userextra-panel-home', UserExtra.panel.Home);
