Ext.define('App.view.auth.AuthController', {
    extend  : 'Ext.app.ViewController',
    alias   : 'controller.auth',

    onLoginClick : function(){
        var form = this.lookupReference('form');

        if (form.isValid()) {
            form.submit({
                success: function(form, action) {
                    /*localStorage.setItem("isAuthenticated", isAuthenticated);

                    // Remove Login Window
                    this.getView().destroy();

                    // Add the main view to the viewport
                    Ext.widget('app-main');*/

                    Ext.Msg.alert('Success', 'action.result.msg');
                },
                failure: function(form, action) {
                    Ext.Msg.alert('Failed', 'action.result.msg');
                }
            });
        }
    }
});
