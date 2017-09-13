var VerifyPhone = function (config) {
    config = config || {};
    VerifyPhone.superclass.constructor.call(this, config);
};
Ext.extend(VerifyPhone, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('verifyphone', VerifyPhone);

VerifyPhone = new VerifyPhone();