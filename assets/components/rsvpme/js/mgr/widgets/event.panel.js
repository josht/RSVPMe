RSVPMe.panel.Event = function(config) {
    config = config|| {};
    Ext.applyIf(config,{
        id: 'rsvpme-panel-event'
        ,url: RSVPMe.config.connector_url
        ,baseParams: {}
        ,items: [{
            html: '<h2>'+_('rsvpme.event_manage')+'</h2>'
            ,border: false
            ,id: 'rm-package-name'
            ,cls: 'modx-page-header'
        },{
            layout: 'form'
            ,defaults: {
                style: 'padding:15px 10px 5px;'
            }
            ,border: true
            ,items: [{
                html: '<p>'+_('rsvpme.event_msg')+'</p>'
                ,border: false
            },{
                layout: 'form'
                ,labelWidth: 150
                ,border: false
                ,items: [{
                    xtype: 'hidden'
                    ,name: 'id'
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('name')
                    ,name: 'name'
                    ,weidth: 300
                    ,allowBlank: false
                },{
                    xtype: 'textarea'
                    ,fieldLabel: _('description')
                    ,name: 'description'
                    ,width: 300
                    ,allowBlank: false
                },{
                    xtype: 'xdatetime'
                    ,fieldLabel: _('date')
                    ,name: 'date'
                    ,width: 300
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('rsvpme.regtype_fee')
                    ,name: 'fee'
                    ,width:300
                    ,allowBlank: true
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('rsvpme.regtype_code')
                    ,name: 'code'
                    ,width:300
                    ,allowBlank: true
                }]
            },{
                xtype: 'rsvpme-grid-registered'
                ,cls: 'rsvpme-event-grid'
                ,eventid: config.eventid
                ,preventRender: true
                ,width: '98%'
                ,bodyStyle: 'padding: 0'
            }]
        }]
        ,listeners: {
            'setup' : {fn:this.setup,scope:this}
            ,'beforeSubmit': {fn:this.beforeSubmit,scope:this}
            ,'success': {fn:this.success,scope:this}
        }
    });
    RSVPMe.panel.Event.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe.panel.Event,MODx.FormPanel,{
    setup: function() {
        if (!this.config.eventid) return;
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/event/get'
                ,id: this.config.eventid
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.getForm().setValues(r.object);
                },scope:this}
            }
        });
    }
    ,beforeSubmit: function(o) {
        Ext.apply(o.form.baseParams,{

        });
    }
    ,success: function(o) {
        Ext.getCmp('rsvpme-btn-save').setDisabled(false);
    }
});
Ext.reg('rsvpme-panel-event',RSVPMe.panel.Event);