Ext.define('App.view.site.SiteController', {
    extend : 'App.form.controller.Controller',
    alias  : 'controller.site',

    init : function() {
        this.initForm('siteForm', 'site');
    },

    requires : [
        'App.view.site.SiteForm'
    ]

});
