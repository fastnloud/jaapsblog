Ext.define('App.grid.Main', {
    extend      : 'Ext.grid.Panel',
    selType     : 'checkboxmodel',
    xtype       : 'mainGrid',
    border      : 0,

    listeners : {
        select       : 'onMainGridSelect',
        deselect     : 'onMainGridDeselect',
        itemdblclick : 'onMainGridDblClick'
    },

    dockedItems: [{
        xtype   : 'toolbar',
        dock    : 'top',

        items : [
            {
                xtype   : 'button',
                text    : 'Create New Record',
                handler : 'onMainGridCreateClick'
            },
            {
                xtype     : 'button',
                reference : 'mainGridDeleteButton',
                text      : 'Delete Selection',
                handler   : 'onMainGridDeleteClick',
                disabled  : true
            }
        ]
    }]

});
