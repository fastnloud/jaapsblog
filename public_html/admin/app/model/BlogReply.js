Ext.define('App.model.BlogReply', {
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'id_blog',
        'name',
        'comment',
        'is_admin',
        'timestamp'
    ]
});