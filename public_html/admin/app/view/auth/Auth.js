Ext.define("App.view.auth.Auth",{
    extend  : 'Ext.window.Window',
    xtype   : 'auth',

    requires : [
        'App.view.auth.AuthController',
        'Ext.form.Panel'
    ],

    controller  : 'auth',
    bodyPadding : 10,
    title       : 'Login',
    closable    : false,
    autoShow    : true,

    items: {
        xtype       : 'form',
        reference   : 'form',
        url         : '/auth/user',

        items : [{
            xtype       : 'textfield',
            name        : 'user',
            fieldLabel  : 'user',
            allowBlank  : false
        }, {
            xtype       : 'textfield',
            name        : 'password',
            inputType   : 'password',
            fieldLabel  : 'Password',
            allowBlank  : false
        }, {
            xtype           : 'displayfield',
            hideEmptyLabel  : false,
            value           : 'Enter any non-blank password'
        }],

        buttons : [{
            text        : 'Login',
            formBind    : true,
            listeners   : {
                click: 'onLoginClick'
            }
        }]
    }
});