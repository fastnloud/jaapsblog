Ext.define('App.view.main.MainController', {
    extend : 'Ext.app.ViewController',

    requires : [
        'Ext.MessageBox'
    ],

    onLogoutClick : function () {
        Ext.Msg.confirm('Logout', 'Are you sure?', 'onLogoutConfirm', this);
    },

    onLogoutConfirm : function (choice) {
        if (choice === 'yes') {
            localStorage.removeItem('isAuthenticated');

            this.getView().destroy();

            Ext.widget('authView');
        }
    }
});
