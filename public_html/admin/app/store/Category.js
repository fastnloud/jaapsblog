Ext.define('App.store.Category', {
    extend   : 'Ext.data.Store',
    autoLoad : true,

    fields : [
        'id',
        'label'
    ],

    proxy : {
        type : 'ajax',
        url  : '/admin/category',

        reader : {
            type            : 'json',
            rootProperty    : 'data'
        }
    }

});