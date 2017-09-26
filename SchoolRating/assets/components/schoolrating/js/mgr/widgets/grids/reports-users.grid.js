SchoolRating.grid.ReportsUsers = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'schoolrating-grid-reports-users';
    }
    Ext.applyIf(config, {
        url: SchoolRating.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        baseParams: {
            action: 'mgr/report/getusers',
        },
        listeners: {
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    SchoolRating.grid.ReportsUsers.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(SchoolRating.grid.ReportsUsers, MODx.grid.Grid, {
    windows: {},

    getFields: function () {
        return ['id', 'report_id', 'user_id', 'fullname', 'rating', 'rating_position'];
    },

    getColumns: function () {
        return [{
            header: _('username'),
            dataIndex: 'fullname',
            sortable: true,
            width: 200,
        }, {
            header: _('schoolrating_rating_report_rating'),
            dataIndex: 'rating',
            sortable: true,
            width: 150,
        }, {
            header: _('schoolrating_rating_report_rating_position'),
            dataIndex: 'rating_position',
            sortable: true,
            width: 150,
        }];
    },

    getTopBar: function () {
        return [];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg('schoolrating-grid-reports-users', SchoolRating.grid.ReportsUsers);
