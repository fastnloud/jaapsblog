Ext.define('App.view.page.PageModel', {
    extend  : 'Ext.app.ViewModel',
    alias   : 'viewmodel.page',

    stores : {
        pageStore : {
            autoLoad    : true,
            autoSync    : true,

            fields : [
                'id',
                'title'
            ],

            proxy : {
                type : 'ajax',
                url  : '/admin/page',

                reader : {
                    type            : 'json',
                    rootProperty    : 'data'
                }
            }
        }
    }
});
