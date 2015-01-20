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
            }/*,
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
            }*/
        ]
    }

});