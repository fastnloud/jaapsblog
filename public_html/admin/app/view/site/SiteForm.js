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
                        fieldLabel  : 'Google Analytics code',
                        name        : 'googleAnalytics',
                        bind        : '{record.googleAnalytics}'
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