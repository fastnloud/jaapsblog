Ext.define('App.store.Status', {
    extend   : 'Ext.data.Store',
    autoLoad : true,

    fields : [
        'id',
        'label'
    ],

    proxy : {
        type : 'ajax',
        url  : '/admin/status',

        reader : {
            type            : 'json',
            rootProperty    : 'data'
        }
    }

});
