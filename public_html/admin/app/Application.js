Ext.define('App.Application', {
    extend: 'Ext.app.Application',
    
    name: 'App',

    stores: [
        // TODO: add global / shared stores here
    ],

    views: [
        'App.view.auth.Auth',
        'App.view.main.Main'
    ],
    
    launch: function () {
        var supportsLocalStorage = Ext.supports.LocalStorage,
            isAuthenticated      = false;

        if (!supportsLocalStorage) {
            Ext.Msg.alert('Your browser does not support Local Storage!');
            return;
        }

        isAuthenticated = localStorage.getItem("isAuthenticated");
        Ext.widget(isAuthenticated ? 'app-main' : 'auth');
    }
});
