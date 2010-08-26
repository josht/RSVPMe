var RSVPMe = function(config) {
    config = config || {};
    RSVPMe.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('rsvpme',RSVPMe);

RSVPMe = new RSVPMe();