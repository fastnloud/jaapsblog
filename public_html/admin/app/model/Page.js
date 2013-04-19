Ext.define('App.model.Page', {
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'title',
        'url_string',
        'route',
        'content',
        'status',
        'priority',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ]
});