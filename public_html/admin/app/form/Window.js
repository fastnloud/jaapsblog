Ext.define('App.form.Window', {
    extend          : 'Ext.window.Window',
    modal           : true,
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
    ]

});