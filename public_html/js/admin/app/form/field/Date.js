(function () {
    var parseDate = Ext.form.field.Date.prototype.parseDate;

    Ext.define('App.form.field.Date', {
        override : 'Ext.form.field.Date',

        parseDate : function(value) {

            if (Ext.isString(value)) {
                var dateTime = value.split(/[- :]/);

                if (dateTime.length > 3) {
                    value = new Date(
                        dateTime[0],
                        dateTime[1]-1,
                        dateTime[2],
                        dateTime[3],
                        dateTime[4],
                        dateTime[5]
                    );
                }
            }

            return parseDate.apply(this, arguments);
        }
    });
})();
