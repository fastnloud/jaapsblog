Ext.define('App.store.Reply', {
    extend   : 'Ext.data.Store',
    autoLoad : false,
    autoSync : true,

    constructor : function() {
        this.callParent(arguments);

        this.dataDefaults = {
            name        : '',
            comment     : '',
            timestamp   : 'now()',
            is_admin    : true
        }
    },

    fields : [
        'id',
        'name',
        'comment',
        'is_admin',
        {
            name    : 'timestamp',
            mapping : 'timestamp.date'
        }
    ],

    sorters : [{
        property  : 'timestamp',
        direction : 'DESC'
    }],

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
