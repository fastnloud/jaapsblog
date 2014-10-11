Ext.define('App.view.main.MainController', {
    extend : 'Ext.app.ViewController',

    requires : [
        'Ext.MessageBox'
    ],

    alias : 'controller.main',

    // Logout button
    onClickLogout : function () {
        Ext.Msg.confirm('Confirm', 'Are you sure?', 'onConfirmLogout', this);
    },

    // Confirm logout click
    onConfirmLogout : function (choice) {
        // Logout
        if (choice === 'yes') {
            // Remove the isAuthenticated from localStorage.
            localStorage.removeItem('isAuthenticated');

            // Remove Main View
            this.getView().destroy();

            // Add the Login Window
            Ext.widget('auth');
        }
    }
});
