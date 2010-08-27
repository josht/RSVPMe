Ext.onReady(function() {
    MODx.load({
        xtype: 'rsvpme-page-event'
        ,eventid: RSVPMe.request.eventid
    });
});
RSVPMe.page.Event = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        formpanel: 'rsvpme-panel-event'
        ,buttons: [{
            text: _('save')
            ,id: 'rsvpme-btn-save'
            ,process: 'mgr/event/update'
            ,method: 'remote'
            ,keys: [{
                    key: 's'
                    ,alt: true
                    ,ctrl: true
            }]
        },'-', {
            text: _('rsvpme.back_to_events')
            ,id: 'rsvpme-btn-back'
            ,handler: function() {
                location.href = '?a='+RSVPMe.request.a+'&action=home';
            }
            ,scope: this
        }]
        ,components: [{
            xtype: 'rsvpme-panel-event'
            ,renderTo: 'rsvpme-panel-event-div'
            ,eventid: config.eventid
        }]
    });
    RSVPMe.page.Event.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe.page.Event,MODx.Component);
Ext.reg('rsvpme-page-event',RSVPMe.page.Event);