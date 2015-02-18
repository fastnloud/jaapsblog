Ext.define('App.form.Window', {
    extend          : 'Ext.window.Window',
    width           : 500,
    resizable       : false,
    createRecord    : true,
    border          : 0,

    buttons : [
        {
            text    : 'Save',
            handler : 'onSyncAndCloseClick'
        },
        {
            text    : 'Sync',
            handler : 'onSyncClick'
        },
        {
            text    : 'Cancel',
            handler : 'onCancelClick'
        }
    ],

    listeners : {
        show : function(formWindow) {
            formWindow.up().down('mainGrid').mask()
        },
        close : function(formWindow) {
            formWindow.up().down('mainGrid').unmask()
        }
    }

});