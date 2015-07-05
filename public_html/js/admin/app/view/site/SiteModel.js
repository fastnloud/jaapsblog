Ext.define('App.view.site.SiteModel', {
    extend  : 'Ext.app.ViewModel',
    alias   : 'viewmodel.site',

    constructor : function() {
        this.callParent(arguments);

        this.setStores({
            site: {
                source : Ext.getStore('Site')
            }
        });
    }

});
