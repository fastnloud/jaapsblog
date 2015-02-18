Ext.define('App.view.blog.BlogForm', {
    extend  : 'App.form.Window',
    xtype   : 'blogForm',

    items : {

        xtype : 'tabpanel',

        items : [
            {
                title       : 'Blog Item',
                xtype       : 'formtab',

                items: [
                    {
                        fieldLabel  : 'Title',
                        name        : 'title',
                        bind        : '{record.title}',
                        allowBlank  : false
                    },
                    {
                        fieldLabel  : 'Subtitle',
                        name        : 'subtitle',
                        bind        : '{record.subtitle}',
                        allowBlank  : false
                    },
                    {
                        fieldLabel  : 'Slug',
                        name        : 'slug',
                        bind        : '{record.slug}',
                        allowBlank  : false
                    },
                    {
                        xtype       : 'textarea',
                        fieldLabel  : 'Lead',
                        name        : 'lead',
                        bind        : '{record.lead}'
                    },
                    {
                        xtype       : 'htmleditor',
                        fieldLabel  : 'Content',
                        name        : 'content',
                        enableFont  : false,

                        bind : {
                            value : '{record.content}'
                        }
                    },
                    {
                        fieldLabel  : 'Author',
                        name        : 'author',
                        bind        : '{record.author}',
                        allowBlank  : false
                    },
                    {
                        xtype       : 'datefield',
                        fieldLabel  : 'Date',
                        name        : 'date',
                        bind        : '{record.date}',
                        format      : 'Y-m-d',
                        allowBlank  : false
                    },
                    {
                        xtype           : 'combobox',
                        fieldLabel      : 'Status',
                        name            : 'status',
                        bind            : '{record.status}',
                        store           : 'Status',
                        queryMode       : 'local',
                        valueField      : 'id',
                        displayField    : 'label',
                        allowBlank      : false
                    }
                ]
            },
            {
                title       : 'SEO',
                xtype       : 'formtab',

                items: [
                    {
                        fieldLabel  : 'Title',
                        name        : 'meta_title',
                        bind        : '{record.meta_title}'
                    },
                    {
                        xtype       : 'textarea',
                        fieldLabel  : 'Description',
                        name        : 'meta_description',
                        bind        : '{record.meta_description}'
                    },
                    {
                        fieldLabel  : 'Keywords',
                        name        : 'meta_keywords',
                        bind        : '{record.meta_keywords}'
                    }
                ]
            },
            {
                title           : 'Replies',
                xtype           : 'childGrid',
                bind            : 'Reply',

                filters : [{
                    property    : 'blog_id',
                    value       : 'id'
                }],

                columns : [
                    {
                        text        : 'Name',
                        flex        : 1,
                        dataIndex   : 'name',
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Comment',
                        dataIndex   : 'comment',
                        editor      : 'textarea',
                        width       : 200,
                        hideable    : false
                    },
                    {
                        text        : 'Date',
                        width       : 120,
                        dataIndex   : 'timestamp',
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Admin',
                        width       : 60,
                        dataIndex   : 'is_admin',
                        editor      : 'checkbox'
                    }
                ]
            }
        ]
    }

});