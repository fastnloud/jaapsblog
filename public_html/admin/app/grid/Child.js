Ext.define('App.grid.Child', {
    extend              : 'Ext.grid.Panel',
    selType             : 'checkboxmodel',
    xtype               : 'childGrid',
    scroll              : 'vertical',
    minHeight           : 250,
    maxHeight           : 400,
    forceFit            : true,

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
