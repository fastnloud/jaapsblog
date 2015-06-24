Ext.define('App.store.Site', {
    extend   : 'Ext.data.Store',
    autoLoad : false,

    fields : [
        'id',
        'title'
    ],

    proxy : {
        type : 'ajax',
        url  : '/admin/site',

        reader : {
            type            : 'json',
            rootProperty    : 'data'
        }
    }

});
