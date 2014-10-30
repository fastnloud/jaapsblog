Ext.define('App.view.blog.Blog',{
    extend      : 'Ext.panel.Panel',
    controller  : 'blog',
    xtype       : 'blogview',

    requires : [
        'App.view.blog.BlogController',
        'App.view.blog.BlogModel'
    ],

    viewModel : {
        type : 'blog'
    },

    items : [
        {
            xtype   : 'tabgrid',
            bind    : '{blog}',

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
