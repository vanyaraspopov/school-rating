SchoolRating.window.Winners = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-winners-window';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_winners'),
        width: 700,
        resizable: false,
        collapsible: false,
        maximized: true,
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
            xtype: 'schoolrating-grid-winners'
        };
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-winners-window', SchoolRating.window.Winners);