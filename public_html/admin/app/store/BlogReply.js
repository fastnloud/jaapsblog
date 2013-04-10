Ext.define('App.store.BlogReply', {
    extend      : 'Ext.data.Store',
    model       : 'App.model.BlogReply',
    autoLoad    : false,

    sorters     : [{
        property: 'timestamp',
        direction: 'ASC'
    }],

    filters     : [
        function(item) {
            return item.id_blog = 0;
        }
    ],

    proxy: {
        type: 'ajax',
        api: {
            read    : '/admin/blog/index-reply',
            update  : '/admin/blog/edit-reply',
            create  : '/admin/blog/edit-reply',
            destroy : '/admin/blog/delete-reply'
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