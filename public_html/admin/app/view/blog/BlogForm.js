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
                        flex        : 2,
                        dataIndex   : 'name',
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Comment',
                        dataIndex   : 'comment',
                        editor      : 'textarea',
                        flex        : 5,
                        hideable    : false
                    },
                    {
                        text        : 'Date',
                        flex        : 3,
                        dataIndex   : 'timestamp',
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Admin',
                        flex        : 2,
                        dataIndex   : 'is_admin',
                        editor      : 'checkbox'
                    }
                ]
            }
        ]
    }

});