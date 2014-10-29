Ext.define('App.Application', {
    extend  : 'Ext.app.Application',
    name    : 'App',

    requires : [
        'App.grid.Tab',
        'App.form.Form',
        'App.form.controller.Controller',
        'App.form.field.ComboBox'
    ],

    stores: [
        'Status'
    ],

    views : [
        'App.view.auth.Auth',
        'App.view.main.Main',
        'App.view.page.Page'
    ],
    
    launch : function () {
        var supportsLocalStorage = Ext.supports.LocalStorage,
            isAuthenticated      = false;

        if (!supportsLocalStorage) {
            Ext.Msg.alert('Your browser does not support Local Storage!');
            return;
        }

        isAuthenticated = localStorage.getItem("isAuthenticated");
        Ext.widget(isAuthenticated ? 'mainview' : 'authview');
    }
});
