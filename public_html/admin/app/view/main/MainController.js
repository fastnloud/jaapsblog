Ext.define('App.view.main.MainController', {
    extend : 'Ext.app.ViewController',

    requires : [
        'Ext.MessageBox'
    ],

    onClickLogout : function () {
        Ext.Msg.confirm('Confirm', 'Are you sure?', 'onConfirmLogout', this);
    },

    onConfirmLogout : function (choice) {
        if (choice === 'yes') {
            localStorage.removeItem('isAuthenticated');

            this.getView().destroy();

            Ext.widget('authView');
        }
    }
});
