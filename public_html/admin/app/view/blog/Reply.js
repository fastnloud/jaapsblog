Ext.define('App.view.blog.Reply' ,{
    extend   : 'Ext.grid.Panel',
    alias    : 'widget.blogReply',
    title    : 'Replies',
    store    : 'BlogReply',
    id       : 'blogReply',
    selType  : 'cellmodel',
    plugins  : [
        Ext.create('Ext.grid.plugin.CellEditing', {
            clicksToEdit: 2
        })
    ],

    initComponent: function() {
        this.columns = [
            {header: 'Name',  dataIndex: 'name',  flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: false
                }
            },
            {header: 'Comment',  dataIndex: 'comment',  flex: 2,
                editor: {
                    xtype: 'textareafield',
                    allowBlank: false
                }
            },
            {header: 'Timestamp',  dataIndex: 'timestamp',  flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: false,
                    disabled: true
                }
            }
        ];

        this.callParent(arguments);
    },

    dockedItems: [{
        xtype   : 'toolbar',
        dock    : 'top',
        items: [
            {
                text    : 'Create',
                action  : 'create',
                disabled : true
            },
            {
                xtype    : 'button',
                text     : 'Delete',
                action   : 'destroy',
                disabled : true
            }
        ]
    }]

});