SchoolRating.combo.Section = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'section'
        ,hiddenName: 'section_id'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['id','name']
        ,pageSize: 10
        ,hideMode: 'offsets'
        ,emptyText: _('schoolrating_section_choice')
        ,url: SchoolRating.config['connector_url']
        ,baseParams: {
            action: 'mgr/section/getList'
            , addAll: true
        }
    });
    SchoolRating.combo.Section.superclass.constructor.call(this,config);
};
Ext.extend(SchoolRating.combo.Section,MODx.combo.ComboBox);
Ext.reg('schoolrating-combo-section',SchoolRating.combo.Section);

SchoolRating.combo.Coefficient = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'coefficient'
        ,hiddenName: 'coefficient'
        ,displayField: 'name'
        ,valueField: 'value'
        ,fields: ['id','name','value']
        ,pageSize: 10
        ,hideMode: 'offsets'
        ,emptyText: _('schoolrating_coefficient_choice')
        ,url: SchoolRating.config['connector_url']
        ,baseParams: {
            action: 'mgr/coefficient/getList'
            , addAll: true
        }
    });
    SchoolRating.combo.Coefficient.superclass.constructor.call(this,config);
};
Ext.extend(SchoolRating.combo.Coefficient,MODx.combo.ComboBox);
Ext.reg('schoolrating-combo-coefficient',SchoolRating.combo.Coefficient);