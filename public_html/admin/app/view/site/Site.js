Ext.define('App.view.site.Site',{
    extend      : 'Ext.panel.Panel',
    controller  : 'site',
    xtype       : 'siteView',
    layout      : 'fit',

    requires : [
        'App.view.site.SiteController',
        'App.view.site.SiteModel'
    ],

    viewModel : {
        type : 'site'
    },

    items : [
        {
            xtype   : 'mainGrid',
            bind    : '{site}',

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
                    text        : 'Domain',
                    flex        : 1,
                    dataIndex   : 'domain'
                },
                {
                    text        : 'Status',
                    flex        : 1,
                    dataIndex   : 'status',
                    renderer    : function(value) {
                        return App.global.Function.storeRenderer(value, 'Status', 'label');
                    }
                }
            ]
        }
    ]
});
