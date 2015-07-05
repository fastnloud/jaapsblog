Ext.define('App.view.site.SiteController', {
    extend : 'App.form.controller.Controller',
    alias  : 'controller.site',

    init : function() {
        this.initForm('siteForm', 'Site');
    },

    requires : [
        'App.view.site.SiteForm'
    ]

});
