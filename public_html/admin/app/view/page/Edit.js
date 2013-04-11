Ext.define('App.view.page.Edit', {
    extend      : 'Ext.window.Window',
    alias       : 'widget.pageEdit',
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
                        name : 'url_string',
                        fieldLabel: 'Address (URL String)',
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