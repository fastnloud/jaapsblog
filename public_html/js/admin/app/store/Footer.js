Ext.define('App.store.Footer', {
    extend   : 'Ext.data.Store',
    alias    : 'store.footer',
    autoLoad : false,
    autoSync : true,

    constructor : function() {
        this.callParent(arguments);

        this.dataDefaults = {
            label         : '',
            href          : '',
            status        : 2,
            priority      : 0,
            footer_column : 1
        }
    },

    fields : [
        'id',
        'label',
        'href',
        'priority',
        'footer_column',
        'status'
    ],

    sorters : [{
        property  : 'priority',
        direction : 'ASC'
    }],

    proxy : {
        type : 'ajax',
        url  : '/admin/footer',

        api : {
            read    : '/admin/footer/read',
            update  : '/admin/footer/update',
            create  : '/admin/footer/create',
            destroy : '/admin/footer/destroy'
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
