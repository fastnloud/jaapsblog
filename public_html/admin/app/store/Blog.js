Ext.define('App.store.Blog', {
    extend      : 'Ext.data.Store',
    model       : 'App.model.Blog',
    autoLoad    : false,

    sorters     : [{
        property: 'date',
        direction: 'DESC'
    }],

    proxy: {
        type: 'ajax',
        api: {
            read    : '/admin/blog/index',
            update  : '/admin/blog/edit',
            create  : '/admin/blog/edit',
            destroy : '/admin/blog/delete'
        },
        writer: {
            type: 'json',
            root: 'data',
            encode: true
        },
        reader: {
            type: 'json',
            root: 'data',
            successProperty: 'success'
        }
    }
});