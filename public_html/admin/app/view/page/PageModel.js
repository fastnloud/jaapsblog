Ext.define('App.view.page.PageModel', {
    extend  : 'Ext.app.ViewModel',

    stores : {
        page : {
            autoLoad : true,

            fields : [
                'id',
                'title',
                'content',
                'label',
                'url',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'status'
            ],

            proxy : {
                type : 'ajax',
                url  : '/admin/page',

                api: {
                    read    : '/admin/page/read',
                    update  : '/admin/page/update',
                    create  : '/admin/page/create',
                    destroy : '/admin/page/delete'
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
