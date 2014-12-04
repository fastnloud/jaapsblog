Ext.define('App.view.blog.BlogForm', {
    extend  : 'App.form.Form',
    xtype   : 'blogForm',

    items : {

        xtype : 'tabpanel',

        items : [
            {
                title       : 'Blog Item',
                xtype       : 'form',
                defaultType : 'textfield',
                padding     : '10 10 0 10',

                fieldDefaults : {
                    width : '100%'
                },

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
                        fieldLabel  : 'URL',
                        name        : 'url',
                        bind        : '{record.url}',
                        allowBlank  : false
                    },
                    {
                        xtype       : 'textarea',
                        fieldLabel  : 'Lead',
                        name        : 'lead',
                        bind        : '{record.lead}'
                    },
                    {
                        xtype       : 'textarea',
                        fieldLabel  : 'Content',
                        name        : 'content',
                        bind        : '{record.content}'
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
                        fieldLabel      : 'Category',
                        name            : 'category',
                        bind            : '{record.category}',
                        store           : 'Category',
                        queryMode       : 'local',
                        valueField      : 'id',
                        displayField    : 'label',
                        allowBlank      : false
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
                    },
                    {
                        xtype       : 'fieldset',
                        defaultType : 'textfield',
                        title       : 'SEO',

                        layout : {
                            type: 'vbox'
                        },

                        items : [
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
                        hideable    : false,
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Comment',
                        flex        : 2,
                        dataIndex   : 'comment',
                        hideable    : false,
                        editor      : 'textarea'
                    },
                    {
                        text        : 'Date',
                        width       : 75,
                        dataIndex   : 'timestamp',
                        hideable    : false,
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Admin',
                        width       : 75,
                        dataIndex   : 'is_admin',
                        hideable    : false,
                        editor      : 'checkbox'
                    }
                ]
            }
        ]
    }

});