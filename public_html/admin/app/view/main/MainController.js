Ext.define('App.view.main.MainController', {
    extend : 'Ext.app.ViewController',
    alias  : 'controller.main',

    requires : [
        'Ext.MessageBox'
    ],

    init : function ()
    {
        Ext.data.StoreManager.lookup('Category').load();
        Ext.data.StoreManager.lookup('Reply').load();
        Ext.data.StoreManager.lookup('Status').load();
    },

    onLogoutClick : function () {
        Ext.Msg.confirm('Logout', 'Are you sure?', 'onLogoutConfirm', this);
    },

    onLogoutConfirm : function (choice) {
        var me = this;

        if (choice === 'yes') {
            Ext.Ajax.request({
                url : '/auth/user/logout',

                success : function() {
                    localStorage.removeItem('isAuthenticated');

                    me.getView().destroy();

                    Ext.widget('authView');
                }
            });
        }
    }
});
