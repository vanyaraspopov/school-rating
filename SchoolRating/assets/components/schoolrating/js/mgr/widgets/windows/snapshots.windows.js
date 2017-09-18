SchoolRating.window.Snapshots = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-snapshots-window';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_snapshots'),
        width: 700,
        autoHeight: true,
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
    SchoolRating.window.Snapshots.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.Snapshots, MODx.Window, {

    getFields: function (config) {
        return {
            title: _('schoolrating_snapshots'),
            xtype: 'schoolrating-grid-snapshots'
        };
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-snapshots-window', SchoolRating.window.Snapshots);

SchoolRating.window.UploadSnapshot = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-snapshots-window-upload';
    }
    Ext.applyIf(config, {
        title: _('schoolrating_snapshot_upload'),
        width: 500,
        height: 200,
        saveBtnText: _('upload'),
        url: SchoolRating.config.connector_url,
        action: 'mgr/snapshot/upload',
        fileUpload: true,
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    SchoolRating.window.UploadSnapshot.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating.window.UploadSnapshot, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'fileuploadfield',
            buttonText: 'Файл...',
            name: 'file',
            id: config.id + '-file',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: MODx.expandHelp ? 'label' : 'hidden',
            forId: config.id + '-file',
            text: _('schoolrating_snapshot_upload_desc'),
            cls: 'desc-under'
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('schoolrating-snapshots-window-upload', SchoolRating.window.UploadSnapshot);