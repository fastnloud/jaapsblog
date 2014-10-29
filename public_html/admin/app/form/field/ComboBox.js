Ext.define('App.form.field.ComboBox', {
    override : 'Ext.form.field.ComboBox',

    listeners : {
        change : function(combobox) {
            if (Ext.isObject(combobox.getValue())) {
                combobox.setValue(combobox.getValue().id);
            }
        }
    }
});