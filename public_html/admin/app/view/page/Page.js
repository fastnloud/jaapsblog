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
            xtype   : 'grid',
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
            ],

            listeners : {
                itemdblclick : 'onGridDblClick'
            },

            dockedItems: [{
                xtype   : 'toolbar',
                dock    : 'top',

                items : [
                    {
                        xtype   : 'button',
                        text    : 'Create New Record',
                        handler : 'onCreateClick'
                    }
                ]
            }]
        }
    ]
});
