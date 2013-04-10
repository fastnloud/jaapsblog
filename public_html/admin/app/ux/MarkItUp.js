Ext.define('Ext.ux.MarkItUp', {
    extend: 'Ext.form.field.TextArea',
    alias: 'widget.markitupfield',
    padding: 0,

    afterRender: function () {
        this.callParent();

        $('#' + this.getId() + ' textarea').markItUp(markItUpSettings);
    }

});