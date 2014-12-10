function getDateTime() {
    var now     = new Date(),
        year    = now.getFullYear(),
        month   = now.getMonth() + 1,
        day     = now.getDate(),
        hour    = now.getHours(),
        minute  = now.getMinutes(),
        second  = now.getSeconds();

    if (month.toString().length == 1)  {
        month = '0' + month;
    }

    if (day.toString().length == 1) {
        day = '0' + day;
    }

    if (hour.toString().length == 1) {
        hour = '0' + hour;
    }

    if (minute.toString().length == 1) {
        minute = '0' + minute;
    }

    if (second.toString().length == 1) {
        second = '0' + second;
    }

    return year
        + '/' + month
        + '/' + day
        + ' ' + hour
        + ':' + minute
        + ':' + second;
}

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
