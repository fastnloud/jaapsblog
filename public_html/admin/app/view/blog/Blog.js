Ext.define('App.view.blog.Blog',{
    extend      : 'Ext.panel.Panel',
    controller  : 'blog',
    xtype       : 'blogView',
    layout      : 'hbox',

    requires : [
        'App.view.blog.BlogController',
        'App.view.blog.BlogModel'
    ],

    viewModel : {
        type : 'blog'
    },

    items : [
        {
            xtype       : 'mainGrid',
            bind        : '{blog}',
            flex        : 1,

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
                },
                {
                    text        : 'Date',
                    flex        : 1,
                    dataIndex   : 'date',
                    xtype       : 'datecolumn',
                    format      : 'Y-m-d'
                }
            ]
        }
    ]
});
