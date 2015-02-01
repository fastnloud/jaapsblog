Ext.define('App.view.main.MainController', {
    extend : 'Ext.app.ViewController',
    alias  : 'controller.main',

    init : function () {
        this.addUserPoll();

        Ext.data.StoreManager.lookup('Status').load();
        Ext.data.StoreManager.lookup('Reply').load();
        Ext.data.StoreManager.lookup('Banner').load();
        Ext.data.StoreManager.lookup('Footer').load();
    },

    addUserPoll : function() {
        var me = this;

        Ext.direct.Manager.addProvider({
            type     :'polling',
            id       : 'userPoll',
            interval : 120000,

            url : function () {
                Ext.Ajax.request({
                    url : '/auth/user/poll',

                    success : function(response) {
                        var jsonObject = Ext.decode(response.responseText);

                        if (!jsonObject.success) {
                            Ext.direct.Manager.getProvider('userPoll').disconnect();
                            Ext.Msg.alert('Error', 'Authentication failed.', function() {
                                me.logout();
                            });
                        }
                    },
                });
            }
        });
    },

    onLogoutClick : function () {
        Ext.Msg.confirm('Logout', 'Are you sure?', 'onLogoutConfirm', this);
    },

    onLogoutConfirm : function (choice) {
        if (choice === 'yes') {
            this.logout();
        }
    },

    logout : function() {
        var me = this;

        Ext.Ajax.request({
            url : '/auth/user/logout',

            success : function() {
                me.getView().destroy();

                Ext.direct.Manager.getProvider('userPoll').disconnect();
                Ext.widget('authView');
            },

            failure : function() {
                me.logout();
            }
        });
    }
});
