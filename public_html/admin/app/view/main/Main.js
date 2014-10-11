Ext.define('App.view.main.Main', {
    extend  : 'Ext.container.Container',
    plugins : 'viewport',

    requires : [
        'App.view.main.MainController',
        'App.view.main.MainModel'
    ],

    xtype       : 'app-main',
    controller  : 'main',

    viewModel : {
        type: 'main'
    },

    layout : {
        type: 'border'
    },

    items : [{
        xtype   : 'panel',
        bind    : {
            title: '{name}'
        },
        region  : 'west',
        html    : '<ul><li>This area is commonly used for navigation, for example, using a "tree" component.</li></ul>',
        width   : 250,
        split   : true,

        tbar: [{
            text    : 'Button',
            handler : 'onClickLogout'
        }]
    },{
        region  : 'center',
        xtype   : 'tabpanel',

        items:[{
            title   : 'Tab 1',
            html    : '<h2>Content appropriate for the current navigation.</h2>'
        }]
    }]
});
