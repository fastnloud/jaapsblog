Ext.define('App.view.page.PageController', {
    extend : 'App.form.controller.Controller',

    init : function() {
        this.initForm('pageform', 'page');
    },

    requires : [
        'App.view.page.PageForm'
    ]

});
