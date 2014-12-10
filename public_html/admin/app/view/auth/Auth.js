Ext.define('App.view.auth.Auth',{
    extend      : 'Ext.window.Window',
    xtype       : 'authView',
    controller  : 'auth',

    requires : [
        'App.view.auth.AuthController',
        'Ext.form.Panel'
    ],

    title       : 'Login',
    closable    : false,
    autoShow    : true,
    draggable   : false,
    resizable   : false,

    items: {
        xtype       : 'form',
        reference   : 'form',
        url         : '/auth/user',
        padding     : 5,
        border      : 1,
        bodyStyle   : 'background:white;padding:5px;',

        items : [
            {
                xtype       : 'textfield',
                name        : 'username',
                fieldLabel  : 'Username',
                allowBlank  : false
            },
            {
                xtype       : 'textfield',
                name        : 'password',
                inputType   : 'password',
                fieldLabel  : 'Password',
                allowBlank  : false
            }
        ],

        buttons : [
            {
                text        : 'Login',
                formBind    : true,

                listeners : {
                    click : 'onLoginClick'
                }
            }
        ]
    }
});
