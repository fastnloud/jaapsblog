Ext.define('App.form.field.HtmlCellEditor', {
    extend         : 'Ext.form.field.HtmlEditor',
    xtype          : 'htmlcelleditor',
    enableFont     : false,
    enableColors   : false,
    height         : 125,

    listeners : {
        resize : function(editor) {
            editor.container.setLeft(0);
            editor.container.setSize('100%', editor.getHeight())
            editor.setSize(editor.container.getWidth(), editor.getHeight());
        }
    }

});