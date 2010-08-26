RSVPMe.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('rsvpme')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('rsvpme.events')
                ,items: [{
                    html: '<p>'+_('rsvpme.intro_msg')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'rsvpme-grid-events'
                    ,preventRender: true
                }]
            }]
        }]
    });
    RSVPMe.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe.panel.Home,MODx.Panel);
Ext.reg('rsvpme-panel-home',RSVPMe.panel.Home);
