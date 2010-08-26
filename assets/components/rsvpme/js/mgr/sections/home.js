Ext.onReady(function() {
    MODx.load({ xtype: 'rsvpme-page-home'});
});

RSVPMe.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'rsvpme-panel-home'
            ,renderTo: 'rsvpme-panel-home-div'
        }]
    }); 
    RSVPMe.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe.page.Home,MODx.Component);
Ext.reg('rsvpme-page-home',RSVPMe.page.Home);