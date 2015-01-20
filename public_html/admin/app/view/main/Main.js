Ext.define('App.view.main.Main', {
    extend      : 'Ext.container.Container',
    plugins     : 'viewport',
    xtype       : 'mainView',
    controller  : 'main',

    requires : [
        'App.view.main.MainController',
        'App.view.main.MainModel'
    ],

    viewModel : {
        type : 'main'
    },

    layout : {
        type : 'border'
    },

    items : [
        {
            xtype       : 'panel',
            region      : 'west',
            width       : 105,
            split       : true,
            collapsible : true,
            collapsed   : true,

            bind : {
                title : '{name}'
            },

            tbar : [
                {
                    text    : 'Logout',
                    handler : 'onLogoutClick',
                    width   : '100%'
                }
            ]
        },
        {
            region : 'center',
            xtype  : 'tabpanel',

            items : [
                {
                    title : 'Pages',
                    xtype : 'pageView'
                },
                {
                    title : 'Blog Items',
                    xtype : 'blogView'
                },
                {
                    title : 'Sites',
                    xtype : 'siteView'
                }
            ]
        }
    ]
});
