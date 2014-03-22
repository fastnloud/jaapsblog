Ext.define('App.model.Blog', {
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'title',
        'subtitle',
        'lead',
        'content',
        'author',
        'date',
        'category',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ]
});