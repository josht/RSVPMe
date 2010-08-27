RSVPMe.grid.Registered = function(config) {
    config = config || {};
    this.sm = new Ext.grid.CheckboxSelectionModel();
    
    Ext.applyIf(config,{
        url: RSVPMe.config.connector_url
        ,baseParams: {
            action: 'mgr/registered/getList'
            ,event: config.eventid
        }
        ,fields: ['id','name','email','date','paid','canceled','event']
        ,paging: true
        ,autoSave: false
        ,remoteSort: true
        ,primaryKey: 'date'
        ,autoExpandColumn: 'name'
        ,sm: this.sm
        ,columns: [this.sm,{
            header: _('name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 300
        },{
            header: _('email')
            ,dataIndex: 'email'
            ,sortable: false
            ,width: 300
        },{
            header: _('date')
            ,dataIndex: 'date'
            ,sortable: true
            ,width: 100
        },{
            header: _('rsvpme.registered_paid')
            ,dataIndex: 'paid'
            ,sortable: true
            ,width: 50
        }]
        ,tbar: [{
            text: _('rsvpme.show_canceled')
            ,handler: this.toggleDeleted
            ,enableToggle: true
            ,scope: this
        },'->',{
            xtype: 'textfield'
            ,name: 'search'
            ,id: 'rsvpme-tf-search'
            ,emptyText: _('search')+'...'
            ,listeners: {
                'change' : {fn: this.search, scope: this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true;}
                        ,scope: cmp
                    });
                },scope:this}
            }
        },{
            xtype: 'button'
            ,id: 'modx-filter-clear'
            ,text: _('filter_clear')
            ,listeners: {
                'click': {fn: this.clearFilter, scope: this}
            }
        }]
    });
    RSVPMe.grid.Registered.superclass.constructor.call(this,config)
};
Ext.extend(RSVPMe.grid.Registered,MODx.grid.Grid,{
    _addEnterKeyHandler: function() {
        this.getEl().addKeyListener(Ext.EventObject.ENTER,function() {
            this.fireEvent('change');
        },this);
    }
    ,clearFilter: function() {
        var s = this.getStore();
        s.baseParams.search = '';
        Ext.getCmp('rsvpme-tf-search').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,search: function(tf,newValue,oldValue) {
        var nv = newValue || tf;
        this.getStore().baseParams.search = nv;
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,toggleDeleted: function(btn,e) {
        var s = this.getStore();
        if (btn,pressed) {
            s.setBaseParam('deleted',1);
            btn.setText(_('rsvpme.hide_canceled'));
        } else {
            s.setBaseParam('deleted',0);
            btn.setText(_('rsvpme.show_canceled'));
        }
        this.getBottomToolbar().changePage(1);
        s.removeAll();
        this.refresh();
    }
    ,getSelectedAsList: function() {
        var sels = this.getSelectionModel().getSelections();
        if (sels.length <= 0) return false;

        var cs = '';
        for (var i=0;i<sels.length;i++) {
            cs += ','+sels[i].data.id;
        }
        cs = Ext.util.Format.substr(cs,1,cs.length-1);
        return cs;
    }
    ,cancelSelected: function (btn,e) {
        var cs = this.getSelectedAsList();
        if (cs === false) return false;

        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/registered/cancelMultiple'
                ,registered: cs
            }
            ,listeners: {
                'success': {fn:function(r) {
                        this.getSelectionModel().clearSelections(true);
                        this.refresh();
                },scope:this}
            }
        });
        return true;
    }
    ,cancelRegistration: function() {
        MODx.msg.confirm({
            title: _('warning')
            ,text: _('rsvpme.registered_delete_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/registered/cancel'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.removeActiveRow,scope:this}
            }
        });
    }
    ,uncancelRegistration: function() {
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/registered/uncancel'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    ,updateRegistration: function(btn,e) {
        if (!this.updateRegistrationWindow) {
            this.updateRegistrationWindow = MODx.load({
                xtype: 'rsvpme-window-registered-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateRegistrationWindow.setValues(this.menu.record);
        this.updateRegistrationWindow.show(e.target);
    }
    ,getMenu: function() {
        var n = this.menu.record;
        var cls = n.cls.split(',');
        var m = [];

        if (cls.indexOf('pupdate') != -1) {
            m.push({
                text: _('rsvpme.registered_update')
                ,handler: this.updateRegistration
            });
        }
        this.addContextMenuItem(m);
    }
});
Ext.reg('rsvpme-grid-registered',RSVPMe.grid.Registered);

RSVPMe.window.UpdateRegistered = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('rsvpme.registered_update')
        ,baseParams: {
            action: 'mgr/registered/update'
        }
        ,width: 600
        ,fields: [{
             xtype: 'hidden'
             ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,anchor: '90%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('email')
            ,name: 'email'
            ,anchor: '90%'
        },{
            xtype: 'checkbox'
            ,fieldLabel: _('rsvpme.registered_paid')
            ,name: 'paid'
            ,anchor: '90%'
        }]
        ,keys: []
    });
    RSVPMe.window.UpdateRegistered.superclass.constructor.call(this,config);
};
Ext.extend(RSVPMe.window.UpdateRegistered,MODx.Window);
Ext.reg('rsvpme-window-registered-update',RSVPMe.window.UpdateRegistered);