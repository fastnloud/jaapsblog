Ext.define('App.view.page.Page',{
    extend      : 'Ext.grid.Panel',
    xtype       : 'pageView',
    controller  : 'page',

    bind : {
        store : '{pageStore}'
    },

    requires : [
        'App.view.page.PageController',
        'App.view.page.PageModel'
    ],

    viewModel : {
        type : 'page'
    },

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
});
