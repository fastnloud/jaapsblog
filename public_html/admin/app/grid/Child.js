Ext.define('App.grid.Child', {
    extend              : 'Ext.grid.Panel',
    selType             : 'checkboxmodel',
    xtype               : 'childGrid',

    initComponent : function() {
        this.callParent();
    },

    plugins : {
        ptype           : 'cellediting',
        clicksToEdit    : 2
    },

    listeners : {
        beforerender    : 'onChildGridBeforeRender',
        itemcontextmenu : 'onChildGridItemContextMenu'
    }

});