Ext.define('App.view.page.List' ,{
    extend  : 'Ext.grid.Panel',
    alias   : 'widget.pageList',
    title   : 'Items',
    store   : 'Page',
    id      : 'pageList',

    initComponent: function() {
        this.columns = [
            {header: 'Title',  dataIndex: 'title',  flex: 3},
            {header: 'Address (URL String)', dataIndex: 'url_string', flex: 3},
            {header: 'Route',  dataIndex: 'route',  flex: 1},
            {header: 'Priority',  dataIndex: 'priority',  flex: 1},
            {header: 'Status',  dataIndex: 'status',  flex: 1}
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