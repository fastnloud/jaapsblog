Ext.define('App.view.auth.AuthController', {
    extend  : 'Ext.app.ViewController',
    alias   : 'controller.auth',

    onLoginClick : function(){
        var isAuthenticated = true;

        if (true === isAuthenticated) {
            localStorage.setItem("isAuthenticated", true);

            // Remove Login Window
            this.getView().destroy();

            // Add the main view to the viewport
            Ext.widget('app-main');
        }
    }
});
