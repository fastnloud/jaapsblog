Ext.define('App.model.Page', {
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'title',
        'url_string',
        'content',
        //'status',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ]
});