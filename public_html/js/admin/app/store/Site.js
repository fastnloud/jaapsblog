Ext.define('App.store.Site', {
    extend   : 'Ext.data.Store',
    autoLoad : false,

    sorters : [{
        property  : 'title',
        direction : 'ASC'
    }],

    fields : [
        'id',
        'title',
        'domain',
        {
            name     : 'status',
            sortType : function(value) {
                return value.label;
            }
        }
    ],

    proxy : {
        type : 'ajax',
        url  : '/admin/site',

        api : {
            read    : '/admin/site/read',
            update  : '/admin/site/update',
            create  : '/admin/site/create',
            destroy : '/admin/site/destroy'
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
