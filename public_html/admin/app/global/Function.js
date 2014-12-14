Ext.define('App.global.Function', {
    statics : {
        getDateTime : function() {
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
        },

        storeRenderer : function(value, storeName, storeDisplayField) {
            if (Ext.isObject(value)) {
                return value.label;
            } else if (Ext.isNumeric(value)) {
                var store = Ext.data.StoreManager.lookup(storeName);

                if (store) {
                    var result = store.getById(value);

                    if (result) {
                        return result.data[storeDisplayField];
                    }
                }
            }

            return null;
        }
    }
});