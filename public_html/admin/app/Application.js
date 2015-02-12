Ext.define('App.Application', {
    extend  : 'Ext.app.Application',
    name    : 'App',

    requires : [
        'App.global.Function',
        'App.grid.Main',
        'App.grid.Child',
        'App.form.Window',
        'App.form.Tab',
        'App.form.controller.Controller',
        'App.form.field.ComboBox',
        'App.form.field.Date',
        'App.form.field.HtmlCellEditor'
    ],

    stores: [
        'Route',
        'Status',
        'Reply',
        'Banner',
        'Footer'
    ],

    views : [
        'App.view.auth.Auth',
        'App.view.main.Main',
        'App.view.page.Page',
        'App.view.blog.Blog',
        'App.view.site.Site'
    ],
    
    launch : function () {
        Ext.Ajax.request({
            url : '/auth/user/poll',

            success : function(response) {
                var jsonObject = Ext.decode(response.responseText);

                if (jsonObject.success) {
                    Ext.widget('mainView')
                } else {
                    Ext.widget('authView');
                };
            },

            failure : function () {
                Ext.widget('authView');
            }
        });
    }
});
