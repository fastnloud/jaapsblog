Ext.define('App.store.Banner', {
    extend   : 'Ext.data.Store',
    alias    : 'store.banner',
    autoLoad : false,
    autoSync : true,

    constructor : function() {
        this.callParent(arguments);

        this.dataDefaults = {
            title     : '',
            content   : '',
            status    : 2,
            priority  : 0
        }
    },

    fields : [
        'id',
        'title',
        'content',
        'priority'
    ],

    sorters : [{
        property  : 'priority',
        direction : 'ASC'
    }],

    proxy : {
        type : 'ajax',
        url  : '/admin/banner',

        api: {
            read    : '/admin/banner/read',
            update  : '/admin/banner/update',
            create  : '/admin/banner/create',
            destroy : '/admin/banner/destroy'
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
