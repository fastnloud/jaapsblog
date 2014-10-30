(function () {
    var parseDate = Ext.form.field.Date.prototype.parseDate;

    Ext.define('App.form.field.Date', {
        override : 'Ext.form.field.Date',

        parseDate : function(value) {
            if (Ext.isObject(value)) {
                value = new Date(value.date);
            }

            return parseDate.apply(this, arguments);
        }
    });
})();
