var UserExtra = function (config) {
    config = config || {};
    UserExtra.superclass.constructor.call(this, config);
};
Ext.extend(UserExtra, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('userextra', UserExtra);

UserExtra = new UserExtra();