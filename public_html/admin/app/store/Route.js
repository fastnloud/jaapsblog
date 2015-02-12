Ext.define('App.store.Route', {
    extend   : 'Ext.data.Store',
    autoLoad : false,

    fields : [
        'id',
        'label'
    ],

    proxy : {
        type : 'ajax',
        url  : '/admin/route',

        reader : {
            type            : 'json',
            rootProperty    : 'data'
        }
    }

});
