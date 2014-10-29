Ext.define('App.grid.Tab', {
    extend      : 'Ext.grid.Panel',
    selType     : 'checkboxmodel',
    xtype       : 'tabgrid',

    listeners : {
        select       : 'onGridSelect',
        deselect      : 'onGridDeselect',
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
                reference : 'deletebutton',
                text      : 'Delete selection',
                handler   : 'onDeleteClick',
                disabled  : true
            }
        ]
    }]

});
