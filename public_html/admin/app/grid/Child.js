Ext.define('App.grid.Child', {
    extend              : 'Ext.grid.Panel',
    selType             : 'checkboxmodel',
    xtype               : 'childGrid',
    cls                 : 'child-grid',
    height              : 250,

    plugins : {
        ptype           : 'rowediting',
        clicksToEdit    : 1
    },

    listeners : {
        beforerender         : 'onChildGridBeforeRender',
        itemcontextmenu      : 'onChildGridItemContextMenu',
        containercontextmenu : 'onChildGridContainerContextMenu',
        beforeedit           : 'onChildGridBeforeEdit'
    }

});
