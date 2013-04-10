Ext.Loader.setPath('Ext.ux', 'app/ux');

Ext.application({
    appFolder   : 'app',
    name        : 'App',

    requires: ['Ext.ux.MarkItUp'],

    controllers: [
        'Auth',
        'Page',
        'Blog',
        'BlogReply'
    ],

    launch: function() {
        this.viewport = Ext.create('Ext.container.Viewport', {
            layout: {
                type: 'fit'
            }
        });
    }
});