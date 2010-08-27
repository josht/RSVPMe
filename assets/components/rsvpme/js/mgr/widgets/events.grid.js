
RSVPMe.grid.Events = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'rsvpme-grid-events'
        ,url: RSVPMe.config.connector_url
        ,baseParams: { action: 'mgr/event/getlist' }
        ,fields: ['id','name','description','date','fee','code']
        ,primaryKey: 'id'
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,listeners: {
            'rowdblclick': {fn: this.manageEvent, scope: this}
        }
        ,columns: [{
            header: _('name')
            ,sortable: true
            ,dataIndex: 'name'
            ,width: 50
        }, {
            header: _('description')
            ,sortable: false
            ,dataIndex:'description'
            ,width:200
        }, {
            header: _('date')
            ,sortable: true
            ,dataIndex: 'date'
            ,width: 100
        }]
        ,tbar: [{
            text: _('rsvpme.event_create')
            ,handler: this.createEvent
            ,scope: this
        }]
    });
    RSVPMe.grid.Events.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe.grid.Events,MODx.grid.Grid,{
    windows: {}

    ,manageEvent: function() {
        var redir = '?a='+MODx.request.a+'&action=event&eventid=';

        // needed for double click
        if (typeof(this.menu.record) == "undefined") {
            redir += this.getSelectedAsList();
        } else {
            redir += this.menu.record.id;
        }
        location.href = redir;
    }
    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('rsvpme.event_manage')
            ,handler: this.manageEvent
        });
        m.push('-');
        m.push({
            text: _('rsvpme.event_remove')
            ,handler: this.removeEvent
        });
        this.addContextMenuItem(m);
    }
    ,updateEvent: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        if (!this.windows.updateEvent) {
            this.windows.updateEvent = MODx.load({
                xtype: 'rsvpme-window-event-update'
                ,record: r
                ,listeners: {
                    'success': {fn:function() { this.refresh();},scope:this}
                }
            });
        }
        this.windows.updateEvent.fp.getForm().reset();
        this.windows.updateEvent.fp.getForm().setValues(r);
        this.windows.updateEvent.show(e.target);
    }

    ,removeEvent: function(btn,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('rsvpme.event_remove')
            ,text: _('rsvpme.event_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/event/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }
});
Ext.reg('rsvpme-grid-events',RSVPMe.grid.Events);


RSVPMe.window.CreateEvent = function(config) {
    config = config || {};
    this.ident = config.ident || 'mecevent'+Ext.id();
    Ext.applyIf(config,{
        title: _('rsvpme.event_create')
        ,id: this.ident
        ,height: 150
        ,width:475
        ,url: RSVPMe.config.connector_url
        ,action: 'mgr/event/create'
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'rsvpme-'+this.ident+'-name'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'rsvpme-'+this.ident+'-description'
            ,width:300
        },{
            xtype: 'xdatetime'
            ,fieldLabel: _('rsvpme.event_date')
            ,name: 'date'
            ,id: 'rsvpme-'+this.ident+'-date'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('rsvpme.regtype_fee')
            ,name: 'code'
            ,id: 'rsvpme-'+this.ident+'-fee'
            ,width:300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('rsvpme.regtype_code')
            ,name: 'code'
            ,id: 'rsvpme-'+this.ident+'-code'
            ,width: 300
        }]
    });
    RSVPMe.window.CreateEvent.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe.window.CreateEvent,MODx.Window);
Ext.reg('rsvpme-window-event-create',RSVPMe.window.CreateEvent);

RSVPMe.window.UpdateEvent = function(config) {
    config = config || {};
    this.ident = config.ident || 'meuevent'+Ext.id();
    Ext.applyIf(config,{
        title: _('rsvpme.event_update')
        ,id: this.ident
        ,height: 150
        ,width: 475
        ,url: RSVPMe.config.connector_url
        ,action: 'mgr/event/update'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
            ,id: 'rsvpme-'+this.ident+'-id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'rsvpme-'+this.ident+'-name'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'rsvpme-'+this.ident+'-description'
            ,width: 300
        },{
            xtype: 'xdatetime'
            ,fieldLabel: _('date')
            ,name: 'date'
            ,id: 'rsvpme-'+this.ident+'-date'
            ,width: 300
        }, {
            xtype: 'textfield'
            ,fieldLabel: _('rsvpme.regtype_fee')
            ,name: 'fee'
            ,id: 'rsvpme-'+this.ident+'=fee'
            ,width:300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('rsvpme.regtype_code')
            ,name: 'code'
            ,id: 'rsvpme-'+this.ident+'-code'
            ,width: 300
        }]
    });
    RSVPMe.window.UpdateEvent.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe.window.UpdateEvent,MODx.Window);
Ext.reg('rsvpme-window-event-update',RSVPMe.window.UpdateEvent);