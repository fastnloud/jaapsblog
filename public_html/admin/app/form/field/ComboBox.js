Ext.define('App.form.field.ComboBox', {
    override       : 'Ext.form.field.ComboBox',
    forceSelection : true,

    listeners : {
        change : function(combobox) {
            if (Ext.isObject(combobox.getValue())) {
                combobox.setValue(combobox.getValue().id);
            }
        }
    }
});