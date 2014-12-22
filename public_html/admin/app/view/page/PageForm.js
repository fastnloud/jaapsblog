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
                        bind        : '{record.slug}'
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
            }
        ]
    }

});