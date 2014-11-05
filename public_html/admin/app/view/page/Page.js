Ext.define('App.view.page.Page',{
    extend      : 'Ext.panel.Panel',
    controller  : 'page',
    xtype       : 'pageView',

    requires : [
        'App.view.page.PageController',
        'App.view.page.PageModel'
    ],

    viewModel : {
        type : 'page'
    },

    items : [
        {
            xtype   : 'mainGrid',
            bind    : '{page}',

            columns : [
                {
                    text        : 'Id',
                    width       : 100,
                    dataIndex   : 'id'
                },
                {
                    text        : 'Title',
                    flex        : 1,
                    dataIndex   : 'title'
                }
            ]
        }
    ]
});
