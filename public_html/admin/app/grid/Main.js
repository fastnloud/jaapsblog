Ext.define('App.grid.Main', {
    extend      : 'Ext.grid.Panel',
    selType     : 'checkboxmodel',
    xtype       : 'mainGrid',

    initComponent : function() {
        this.callParent();
    },

    listeners : {
        select       : 'onGridSelect',
        deselect     : 'onGridDeselect',
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
            },
            {
                xtype     : 'button',
                reference : 'mainGridDeleteButton',
                text      : 'Delete selection',
                handler   : 'onDeleteClick',
                disabled  : true
            }
        ]
    }]

});
