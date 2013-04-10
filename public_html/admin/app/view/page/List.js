Ext.define('App.view.page.List' ,{
    extend  : 'Ext.grid.Panel',
    alias   : 'widget.pageList',
    title   : 'Items',
    store   : 'Page',
    id      : 'pageList',

    initComponent: function() {
        this.columns = [
            {header: 'Title',  dataIndex: 'title',  flex: 1},
            {header: 'Address (URL String)', dataIndex: 'url_string', flex: 1}
        ];

        this.callParent(arguments);
    },

    dockedItems: [{
        xtype   : 'toolbar',
        dock    : 'top',
        items: [
            {
                text    : 'Create',
                action  : 'create'
            },
            {
                text     : 'Delete',
                action   : 'destroy',
                disabled : true
            }
        ]
    }]

});