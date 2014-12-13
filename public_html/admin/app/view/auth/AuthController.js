Ext.define('App.view.auth.AuthController', {
    extend : 'Ext.app.ViewController',
    alias  : 'controller.auth',

    onKeypress : function(field, e) {
        if(e.getKey() == e.ENTER ){
            this.onLoginClick();
        }
    },

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
