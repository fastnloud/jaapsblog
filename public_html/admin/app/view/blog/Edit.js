Ext.define('App.view.blog.Edit', {
    extend      : 'Ext.window.Window',
    alias       : 'widget.blogEdit',
    title       : 'Edit',
    autoShow    : true,
    width       : 740,
    height      : 500,
    autoScroll  : true,
    resizable   : true,
    maximizable : true,

    bodyStyle   : {
        background: 'white'
    },

    onResize: function() {
        this.doLayout();
    },

    initComponent: function() {
        Ext.EventManager.addListener(window, 'resize', function() {
            this.center();
        }, this);

        this.items = [
            {
                xtype: 'form',
                padding: 0,
                bodyPadding: 5,
                border: 0,
                fieldDefaults: {
                    labelAlign: 'left',
                    labelWidth: 120,
                    anchor: '100%'
                },
                items: [
                    {
                        xtype: 'hiddenfield',
                        name : 'id'
                    },
                    {
                        xtype: 'textfield',
                        name : 'title',
                        fieldLabel: 'Title',
                        allowBlank : false
                    },
                    {
                        xtype: 'textfield',
                        name : 'subtitle',
                        fieldLabel: 'Subtitle'
                    },
                    {
                        xtype: 'textareafield',
                        name : 'lead',
                        fieldLabel: 'Lead',
                        allowBlank : false
                    },
                    {
                        xtype: 'markitupfield',
                        name : 'content',
                        fieldLabel: 'Content',
                        height: 200,
                        allowBlank : false
                    },
                    {
                        xtype: 'datefield',
                        name : 'date',
                        fieldLabel: 'Date',
                        format : 'Y-m-d',
                        allowBlank : false,
                        value: new Date()
                    },
                    {
                        xtype: 'combobox',
                        name : 'category',
                        fieldLabel: 'Category',
                        store : ['code snippet', 'media', 'review', 'social'],
                        allowBlank : false,
                        value: 'code snippet'
                    },
                    {
                        xtype: 'combobox',
                        name : 'status',
                        fieldLabel: 'Status',
                        store : ['online', 'offline'],
                        allowBlank : false,
                        value: 'offline'
                    },
                    {
                        xtype: 'fieldset',
                        title: 'Review',
                        collapsible: true,
                        defaults: {
                            labelWidth: 90,
                            anchor: '100%',
                            padding: 10,
                            layout: {
                                type: 'hbox'
                            }
                        },
                        items : [
                            {
                                xtype: 'combobox',
                                name : 'rating',
                                fieldLabel: 'Rating',
                                store : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            }
                        ]
                    },
                    {
                        xtype: 'fieldset',
                        title: 'Amazon',
                        collapsible: true,
                        defaults: {
                            labelWidth: 90,
                            anchor: '100%',
                            padding: 10,
                            layout: {
                                type: 'hbox'
                            }
                        },
                        items : [
                            {
                                xtype: 'textfield',
                                name : 'amazon_item_id',
                                fieldLabel: 'Item Id'
                            }
                        ]
                    },
                    {
                        xtype: 'fieldset',
                        title: 'SEO',
                        collapsible: true,
                        defaults: {
                            labelWidth: 90,
                            anchor: '100%',
                            padding: 10,
                            layout: {
                                type: 'hbox'
                            }
                        },
                        items : [
                            {
                                xtype: 'textfield',
                                name : 'meta_title',
                                fieldLabel: 'Title'
                            },
                            {
                                xtype: 'textareafield',
                                name : 'meta_description',
                                fieldLabel: 'Description'
                            },
                            {
                                xtype: 'textfield',
                                name : 'meta_keywords',
                                fieldLabel: 'Keywords'
                            }
                        ]
                    }
                ]
            }
        ];

        this.callParent(arguments);
    }

});