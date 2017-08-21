var SchoolRating = function (config) {
    config = config || {};
    SchoolRating.superclass.constructor.call(this, config);
};
Ext.extend(SchoolRating, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('schoolrating', SchoolRating);

SchoolRating = new SchoolRating();