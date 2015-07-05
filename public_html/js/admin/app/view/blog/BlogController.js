Ext.define('App.view.blog.BlogController', {
    extend : 'App.form.controller.Controller',
    alias  : 'controller.blog',

    init : function() {
        this.initForm('blogForm', 'Blog');
    },

    requires : [
        'App.view.blog.BlogForm'
    ]

});
