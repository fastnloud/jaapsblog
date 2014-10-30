Ext.define('App.view.blog.BlogModel', {
    extend  : 'Ext.app.ViewModel',
    alias   : 'viewmodel.blog',

    stores : {
        blog : {
            autoLoad : true,

            fields : [
                'id',
                'title',
                'status'
            ],

            proxy : {
                type : 'ajax',
                url  : '/admin/blog',

                api: {
                    read    : '/admin/blog/read',
                    update  : '/admin/blog/update',
                    create  : '/admin/blog/create',
                    destroy : '/admin/blog/delete'
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
        }
    }
});
