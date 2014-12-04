Ext.define('App.form.Form', {
    extend          : 'Ext.window.Window',
    modal           : true,
    width           : 500,
    autoScroll      : true,
    resizable       : false,
    createRecord    : true,

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