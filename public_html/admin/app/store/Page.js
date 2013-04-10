Ext.define('App.store.Page', {
    extend      : 'Ext.data.Store',
    model       : 'App.model.Page',
    autoLoad    : false,

    sorters     : [{
        property: 'title',
        direction: 'ASC'
    }],

    proxy: {
        type: 'ajax',
        api: {
            read    : '/admin/page/index',
            update  : '/admin/page/edit',
            create  : '/admin/page/edit',
            destroy : '/admin/page/delete'
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