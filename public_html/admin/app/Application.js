Ext.define('App.Application', {
    extend  : 'Ext.app.Application',
    name    : 'App',

    requires : [
        'App.grid.Main',
        'App.form.Form',
        'App.form.controller.Controller',
        'App.form.field.ComboBox',
        'App.form.field.Date'
    ],

    stores: [
        'Status',
        'Category'
    ],

    views : [
        'App.view.auth.Auth',
        'App.view.main.Main',
        'App.view.page.Page',
        'App.view.blog.Blog'
    ],
    
    launch : function () {
        var supportsLocalStorage = Ext.supports.LocalStorage,
            isAuthenticated      = false;

        if (!supportsLocalStorage) {
            Ext.Msg.alert('Your browser does not support Local Storage!');
            return;
        }

        isAuthenticated = localStorage.getItem("isAuthenticated");
        Ext.widget(isAuthenticated ? 'mainView' : 'authView');
    }
});
