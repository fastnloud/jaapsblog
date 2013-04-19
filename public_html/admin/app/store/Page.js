Ext.define('App.store.Page', {
    extend      : 'Ext.data.Store',
    model       : 'App.model.Page',
    autoLoad    : false,

    sorters     : [{
        property: 'priority',
        direction: 'ASC'
    }],

    listeners: {
        add: function() {
            this.sync({
                scope: this,
                callback : function() {
                    this.reload();
                }
            });
        }
    },

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