Ext.define('App.store.Reply', {
    extend   : 'Ext.data.Store',
    autoLoad : true,
    autoSync : true,

    constructor : function() {
        this.callParent(arguments);

        this.dataDefaults = {
            name        : '',
            comment     : '',
            timestamp   : new Date()
        }
    },

    fields : [
        'id',
        'name',
        'comment',
        {
            name    : 'timestamp',
            mapping : 'timestamp.date'
        }
    ],

    proxy : {
        type : 'ajax',
        url  : '/admin/reply',

        api: {
            read    : '/admin/reply/read',
            update  : '/admin/reply/update',
            create  : '/admin/reply/create',
            destroy : '/admin/reply/destroy'
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
