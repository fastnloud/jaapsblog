Ext.define('App.view.page.Page',{
    extend      : 'Ext.panel.Panel',
    controller  : 'page',
    xtype       : 'pageview',

    requires : [
        'App.view.page.PageController',
        'App.view.page.PageModel'
    ],

    viewModel : {
        type : 'page'
    },

    items : [
        {
            xtype   : 'tabgrid',
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
