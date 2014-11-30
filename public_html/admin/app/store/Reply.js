Ext.define('App.store.Reply', {
    extend   : 'Ext.data.Store',
    autoLoad : true,

    fields : [
        'id',
        'name',
        'comment',
        'timestamp',
        'blog_id'
    ],

    proxy : {
        type : 'ajax',
        url  : '/admin/reply',

        api: {
            read    : '/admin/reply/read',
            update  : '/admin/reply/update',
            create  : '/admin/reply/create',
            destroy : '/admin/reply/delete'
        },

        reader : {
            type            : 'json',
            rootProperty    : 'data'
        },

        writer : {
            type            : 'json',
            rootProperty    : 'data',
            encode          : true
        }
    }

});
