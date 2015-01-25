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
                        flex        : 2,
                        dataIndex   : 'title',
                        editor      : 'textfield'
                    },
                    {
                        text        : 'Content',
                        dataIndex   : 'content',
                        editor      : 'textarea',
                        flex        : 6,
                        hideable    : false
                    },
                    {
                        text        : 'Priority',
                        dataIndex   : 'priority',
                        editor      : 'numberfield',
                        flex        : 2,
                        hideable    : false
                    },
                    {
                        text        : 'Status',
                        dataIndex   : 'status',
                        flex        : 2,
                        hideable    : false,
                        editor      : {
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