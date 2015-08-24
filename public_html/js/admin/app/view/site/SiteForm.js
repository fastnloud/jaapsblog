Ext.define('App.view.site.SiteForm', {
    extend  : 'App.form.Window',
    xtype   : 'siteForm',

    items : {

        xtype : 'tabpanel',

        items : [
            {
                title       : 'Site',
                xtype       : 'formtab',

                items: [
                    {
                        fieldLabel  : 'Title',
                        name        : 'title',
                        bind        : '{record.title}',
                        allowBlank  : false
                    },
                    {
                        fieldLabel  : 'Domain',
                        name        : 'domain',
                        bind        : '{record.domain}',
                        allowBlank  : false
                    },
                    {
                        fieldLabel  : 'E-mail',
                        name        : 'email',
                        bind        : '{record.email}',
                        allowBlank  : false
                    },
                    {
                        xtype       : 'textarea',
                        fieldLabel  : 'CSS',
                        name        : 'css',
                        bind        : '{record.css}'
                    },
                    {
                        xtype       : 'textarea',
                        fieldLabel  : 'GA-code',
                        name        : 'google_analytics',
                        bind        : '{record.google_analytics}'
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
                title       : 'Social Media',
                xtype       : 'formtab',

                items: [
                    {
                        fieldLabel  : 'Facebook',
                        name        : 'linkedin_url',
                        bind        : '{record.facebook_url}'
                    },
                    {
                        fieldLabel  : 'LinkedIn',
                        name        : 'linkedin_url',
                        bind        : '{record.linkedin_url}'
                    },
                    {
                        fieldLabel  : 'Google+',
                        name        : 'google_plus_url',
                        bind        : '{record.google_plus_url}'
                    }
                ]
            },
            {
                title       : 'Dkim',
                xtype       : 'formtab',

                items: [
                    {
                        xtype   :'fieldset',
                        layout  :'table',
                        margin  : 0,
                        padding : 0,
                        border  : 0,

                        items : [
                            {
                                xtype       : 'textfield',
                                fieldLabel  : 'Domain',
                                name        : 'dkim_domain',
                                bind        : '{record.dkim_domain}'
                            },
                            {
                                xtype          : 'checkbox',
                                name           : 'dkim',
                                bind           : '{record.dkim}',
                                boxLabel       : 'Enabled',
                                padding        : '0 0 0 10px;',
                                hideLabel      : true,
                                inputValue     : true,
                                allowBlank     : false
                            }
                        ]
                    },
                    {
                        fieldLabel  : 'Selector',
                        name        : 'dkim_selector',
                        bind        : '{record.dkim_selector}'
                    },
                    {
                        fieldLabel  : 'Headers',
                        name        : 'dkim_headers',
                        bind        : '{record.dkim_headers}'
                    },
                    {
                        xtype       : 'textarea',
                        fieldLabel  : 'Private Key',
                        name        : 'dkim_private_key',
                        bind        : '{record.dkim_private_key}'
                    }
                ]
            },
            {
                title           : 'Banners',
                xtype           : 'childGrid',
                bind            : 'Banner',

                filters : [{
                    property    : 'site_id',
                    value       : 'id'
                }],

                columns : [
                    {
                        text        : 'Titel',
                        flex        : 1,
                        dataIndex   : 'title',
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Content',
                        dataIndex   : 'content',
                        width       : 200,

                        editor : {
                            xtype : 'htmlcelleditor'
                        }
                    },
                    {
                        text        : 'Priority',
                        dataIndex   : 'priority',
                        editor      : 'numberfield',
                        width       : 70
                    },
                    {
                        text        : 'Status',
                        dataIndex   : 'status',
                        width       : 70,

                        editor : {
                            xtype           : 'combobox',
                            name            : 'status',
                            store           : 'Status',
                            queryMode       : 'local',
                            valueField      : 'id',
                            displayField    : 'label'
                        },

                        renderer : function(value) {
                            return App.global.Function.storeRenderer(value, 'Status', 'label');
                        }
                    }
                ]
            },
            {
                title           : 'Footer Items',
                xtype           : 'childGrid',
                bind            : 'Footer',

                filters : [{
                    property    : 'site_id',
                    value       : 'id'
                }],

                columns : [
                    {
                        text        : 'Label',
                        flex        : 1,
                        dataIndex   : 'label',
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Href',
                        width       : 130,
                        dataIndex   : 'href',
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Priority',
                        dataIndex   : 'priority',
                        editor      : 'numberfield',
                        width       : 70
                    },
                    {
                        text        : 'Column',
                        dataIndex   : 'footer_column',
                        editor      : 'numberfield',
                        width       : 70
                    },
                    {
                        text        : 'Status',
                        dataIndex   : 'status',
                        width       : 70,

                        editor : {
                            xtype           : 'combobox',
                            name            : 'status',
                            store           : 'Status',
                            queryMode       : 'local',
                            valueField      : 'id',
                            displayField    : 'label'
                        },

                        renderer : function(value) {
                            return App.global.Function.storeRenderer(value, 'Status', 'label');
                        }
                    }
                ]
            }
        ]
    }

});