Ext.define('App.view.auth.Login', {
    extend      : 'Ext.window.Window',
    alias       : 'widget.authLogin',
    title       : 'Login',
    id          : 'authLogin',
    autoShow    : false,
    autoScroll  : true,
    resizable   : false,
    closable    : false,

    initComponent: function() {
        Ext.EventManager.addListener(window, 'resize', function() {
            this.center();
        }, this);

        this.items = [
            {
                xtype: 'form',
                padding: 0,
                bodyPadding: 5,
                border: 0,
                fieldDefaults: {
                    labelAlign: 'left',
                    labelWidth: 120,
                    anchor: '100%'
                },
                items: [
                    {
                        xtype: 'textfield',
                        name : 'username',
                        fieldLabel: 'Username'
                    },
                    {
                        xtype: 'textfield',
                        name : 'password',
                        fieldLabel: 'Password',
                        inputType : 'password'
                    }
                ]
            }
        ];

        this.buttons = [
            {text : 'Login', action : 'login'}
        ];

        this.callParent(arguments);
    }

});