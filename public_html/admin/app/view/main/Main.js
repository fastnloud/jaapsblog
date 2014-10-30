Ext.define('App.view.main.Main', {
    extend      : 'Ext.container.Container',
    plugins     : 'viewport',
    xtype       : 'mainview',
    controller  : 'main',

    requires : [
        'App.view.main.MainController',
        'App.view.main.MainModel'
    ],

    viewModel : {
        type: 'main'
    },

    layout : {
        type: 'border'
    },

    items : [
        {
            xtype       : 'panel',
            region      : 'west',
            width       : 150,
            split       : true,
            collapsible : true,

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
                    xtype : 'pageview'
                }
            ]
        }
    ]
});
