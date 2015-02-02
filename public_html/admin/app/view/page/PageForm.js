Ext.define('App.view.page.PageForm', {
    extend  : 'App.form.Window',
    xtype   : 'pageForm',

    items : {

        xtype : 'tabpanel',

        items : [
            {
                title       : 'Page',
                xtype       : 'formtab',

                items: [
                    {
                        fieldLabel  : 'Title',
                        name        : 'title',
                        bind        : '{record.title}',
                        allowBlank  : false
                    },
                    {
                        fieldLabel  : 'Label',
                        name        : 'label',
                        bind        : '{record.label}',
                        allowBlank  : false
                    },
                    {
                        fieldLabel  : 'Slug',
                        name        : 'slug',
                        bind        : '{record.slug}',
                        allowBlank  : false
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
                        xtype       : 'numberfield',
                        fieldLabel  : 'Priority',
                        name        : 'priority',
                        bind        : '{record.priority}',
                        allowBlank  : false
                    },
                    {
                        xtype   :'fieldset',
                        layout  :'table',
                        margin  : 0,
                        padding : 0,
                        border  : 0,

                        items : [
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
                                xtype          : 'checkbox',
                                name           : 'is_visible',
                                bind           : '{record.is_visible}',
                                boxLabel       : 'Visible',
                                padding        : '0 0 0 10px;',
                                hideLabel      : true,
                                allowBlank     : false
                            }
                        ]
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
            }
        ]
    }

});