Ext.define('App.grid.Child', {
    extend              : 'Ext.grid.Panel',
    selType             : 'checkboxmodel',
    xtype               : 'childGrid',
    minHeight           : 250,
    maxHeight           : 400,

    plugins : {
        ptype           : 'rowediting',
        clicksToEdit    : 2
    },

    listeners : {
        beforerender         : 'onChildGridBeforeRender',
        itemcontextmenu      : 'onChildGridItemContextMenu',
        containercontextmenu : 'onChildGridContainerContextMenu',
        beforeedit           : 'onChildGridBeforeEdit'
    }

});
