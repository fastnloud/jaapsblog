Ext.define('App.view.page.PageController', {
    extend : 'App.form.controller.Controller',
    alias  : 'controller.page',

    init : function() {
        this.initForm('pageForm', 'Page');
    },

    requires : [
        'App.view.page.PageForm'
    ]

});
