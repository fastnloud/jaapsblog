Ext.define('App.view.auth.AuthController', {
    extend : 'Ext.app.ViewController',

    onLoginClick : function(){
        var form = this.lookupReference('form'),
            view = this.getView();

        if (form.isValid()) {
            form.submit({
                success : function(form, action) {
                    localStorage.setItem("isAuthenticated", true);

                    view.destroy();

                    Ext.widget('mainView');
                },

                failure : function(form, action) {
                    form.reset();

                    Ext.Msg.alert('Error', action.result.msg);
                }
            });
        }
    }
});
