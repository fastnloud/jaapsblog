Ext.define('App.data.proxy.Ajax', {
    alias  : 'proxy.ajax',
    extend : 'Ext.data.proxy.Ajax',

    headers : {
        'X-Csrf-Token' : App.global.Function.getCsrfToken()
    }

});
