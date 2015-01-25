Ext.define('App.form.Tab', {
    extend        : 'Ext.form.Panel',
    xtype         : 'formtab',
    maxHeight     : 420,
    autoScroll    : true,
    border        : 0,
    defaultType   : 'textfield',
    bodyPadding   : '10 10 5 10',
    background    : 'white',

    fieldDefaults : {
        width : '100%'
    }
});