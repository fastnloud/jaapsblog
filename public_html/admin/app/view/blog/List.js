Ext.define('App.view.blog.List' ,{
    extend  : 'Ext.grid.Panel',
    alias   : 'widget.blogList',
    title   : 'Items',
    store   : 'Blog',
    id      : 'blogList',

    initComponent: function() {
        this.columns = [
            {header: 'Title',  dataIndex: 'title',  flex: 3},
            {header: 'Category',  dataIndex: 'category',  flex: 1},
            {header: 'Status',  dataIndex: 'status',  flex: 1},
            {header: 'Date', dataIndex: 'date', flex: 1}
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