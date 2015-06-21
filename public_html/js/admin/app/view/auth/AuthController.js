Ext.define('App.view.auth.AuthController', {
    extend : 'Ext.app.ViewController',
    alias  : 'controller.auth',

    onAfterRender : function(form) {
        setTimeout(function() {
            form.items.first().setValue('');
            form.items.first().focus(true);
        }, 200);
    },

    onKeypress : function(field, e) {
        if(e.getKey() == e.ENTER ){
            this.onLoginClick();
        }
    },

    onLoginClick : function() {
        var me   = this,
            form = me.lookupReference('form'),
            view = me.getView();

        if (form.isValid()) {
            form.getForm().doAction('submit', {
                url : '/auth/user',

                headers : {
                    'X-Csrf-Token' : App.global.Function.getCsrfToken()
                },

                success : function(task, action) {
                    view.destroy();

                    Ext.widget('mainView');
                },

                failure : function(task, action) {
                    Ext.Msg.alert('Error', action.result.msg, function() {
                        form.reset();
                        form.items.first().focus(true);
                    });
                }
            });
        }
    }
});
