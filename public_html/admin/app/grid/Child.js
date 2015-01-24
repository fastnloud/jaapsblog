Ext.define('App.grid.Child', {
    extend              : 'Ext.grid.Panel',
    selType             : 'checkboxmodel',
    xtype               : 'childGrid',
    scroll              : 'vertical',
    minHeight           : 70,
    maxHeight           : 400,
    forceFit            : true,

    plugins : {
        ptype           : 'cellediting',
        clicksToEdit    : 2
    },

    listeners : {
        beforerender         : 'onChildGridBeforeRender',
        itemcontextmenu      : 'onChildGridItemContextMenu',
        containercontextmenu : 'onChildGridContainerContextMenu',
        beforeedit           : 'onChildGridBeforeEdit'
    }

});
