Ext.define('App.controller.Auth', {
    extend          : 'Ext.app.Controller',
    views           : ['auth.Login'],
    isAuthenticated : false,

    init: function() {
        this.control({
            'viewport': {
                beforerender : this.authenticate,
                afterrender : this.authHandler
            },
            'viewport toolbar button[action=logout]': {
                click: this.authHandlerLogout
            },
            'authLogin button[action=login]': {
                click: this.authHandler
            },
            'authLogin form textfield': {
                specialkey : function(field, e) {
                    if (e.getKey() == e.ENTER) {
                        this.authHandler();
                    }
                }
            }
        })
    },

    authenticate: function() {
        if (true !== this.isAuthenticated) {
            if (!Ext.getCmp('authLogin')) {
                Ext.widget('authLogin');
            }
        } else {
            this.application.viewport.add([{
                layout: 'fit',
                items: {
                    region: 'center',
                    xtype: 'tabpanel',
                    id: 'mainframe',
                    padding: 5,
                    activeTab: 0,
                    items: [{
                        layout: {
                            type: 'hbox',
                            align: 'stretch'
                        },
                        title: 'Blog',
                        anchor: '100%',
                        defaults: {margin:5, frame:true, columnWidth: 0.5 },
                        items: [
                            { xtype: 'blogList', flex: 1 },
                            { xtype: 'blogReply', flex: 1 }
                        ]
                    },{
                        layout: {
                            type: 'hbox',
                            align: 'stretch'
                        },
                        title: 'Pages',
                        anchor: '100%',
                        defaults: {margin:5, frame:true, columnWidth: 0.5 },
                        items: [
                            { xtype: 'pageList', flex: 1 }
                        ]
                    }],
                    dockedItems: [{
                        xtype: 'toolbar',
                        dock: 'bottom',
                        items:[
                            { xtype:'tbspacer',flex: 1 },
                            { text:'Logout', action: 'logout' }
                        ]
                    }]
                }
            }]);
        }
    },

    authHandler: function() {
        var win             = Ext.getCmp('authLogin'),
            form            = win.down('form'),
            values          = form.getValues(),
            scope           = this;

        Ext.Ajax.request({
            url: '/login',
            scope : scope,
            params: values,
            success: function(request) {
                var response = Ext.JSON.decode(request.responseText);
                this.isAuthenticated = response.success === true;

                if (true === this.isAuthenticated) {
                    Ext.getCmp('authLogin').destroy();
                } else {
                    Ext.getCmp('authLogin').show();
                    form.getForm().getFields().getAt(0).focus('', true);
                    form.getForm().getFields().getAt(0).setValue('');
                    form.getForm().getFields().getAt(1).setValue('');
                }

                this.authenticate();
            }
        });
    },

    authHandlerLogout: function() {
        Ext.Ajax.request({
            url: '/logout',
            success : function() {
                location.href = '/admin';
            }
        });
    }

});