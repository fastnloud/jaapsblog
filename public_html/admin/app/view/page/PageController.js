Ext.define('App.view.page.PageController', {
    extend : 'App.form.controller.Controller',
    alias  : 'controller.page',

    init : function() {
        this.initForm('pageform', 'page');
    },

    requires : [
        'App.view.page.PageForm'
    ]

});
