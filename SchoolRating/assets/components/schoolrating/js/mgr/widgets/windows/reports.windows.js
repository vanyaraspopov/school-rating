SchoolRating.window.Reports = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-reports-window';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_rating_reports'),
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
    SchoolRating.window.Reports.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.Reports, MODx.Window, {

    getFields: function (config) {
        return {
            title: _('schoolrating_rating_reports'),
            xtype: 'schoolrating-grid-reports'
        };
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-reports-window', SchoolRating.window.Reports);

SchoolRating.window.CreateReport = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-reports-window-create';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_rating_report_create'),
        width: 500,
        autoHeight: true,
        saveBtnText: _('create'),
        url: SchoolRating.config.connector_url,
        action: 'mgr/report/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.CreateReport.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.CreateReport, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'datefield',
            format: 'd.m.Y',
            fieldLabel: _('schoolrating_rating_report_date_start'),
            name: 'date_start',
            id: config.id + '-date_start',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'datefield',
            fieldLabel: _('schoolrating_rating_report_date_end'),
            format: 'd.m.Y',
            name: 'date_end',
            id: config.id + '-date_end',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'numberfield',
            fieldLabel: _('schoolrating_rating_report_count'),
            name: 'count',
            id: config.id + '-count',
            anchor: '99%',
        }, {
            xtype: 'textarea',
            fieldLabel: _('schoolrating_rating_report_comment'),
            name: 'comment',
            id: config.id + '-comment',
            anchor: '99%',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-reports-window-create', SchoolRating.window.CreateReport);