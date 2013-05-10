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
        'rating',
        'status',
        'amazon_item_id',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ]
});