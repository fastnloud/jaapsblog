Ext.define('App.form.controller.Controller', {
    extend    : 'Ext.app.ViewController',
    name      : null,
    store     : null,
    container : null,

    initForm : function(name, store) {
        this.name  = name;
        this.store = store;
    },

    getName : function() {
        return this.name;
    },

    getStore : function() {
        return this.store;
    },

    setContainer : function(container) {
        this.container = container;
    },

    getContainer : function() {
        return this.container;
    },

    removeContainer : function() {
        this.getView().remove(this.getContainer());
        this.setContainer(null);
    },

    onMainGridSelect : function() {
        this.getView().lookupReference('mainGridDeleteButton').enable();
    },

    onMainGridDeselect : function(grid) {
        var deleteButton = this.getView().lookupReference('mainGridDeleteButton');

        if (!grid.getSelection().length) {
            deleteButton.disable();
        }
    },

    onMainGridDblClick : function(grid, record) {
        this.setContainer(this.getView().add({
            xtype        : this.getName(),
            formStore    : this.getStore(),
            createRecord : false,

            bind: {
                title : 'Edit Record: {record.title}'
            },

            viewModel : {
                data : {
                    record : record
                }
            }
        }).show());
    },

    onMainGridCreateClick : function() {
        this.setContainer(this.getView().add({
            xtype : this.getName(),
            title : 'New Record',

            viewModel : {
                data : {
                    record : []
                }
            }
        }).show());
    },

    onMainGridDeleteClick : function() {
        Ext.Msg.confirm('Delete', 'Are you sure?', 'onMainGridDeleteConfirm', this);
    },

    onMainGridDeleteConfirm : function(choice) {
        if (choice === 'yes') {
            var grid          = this.getView().down('mainGrid'),
                store         = grid.lookupViewModel(true).getStore(this.getStore()),
                selection     = grid.getSelection();

            if (selection.length > 0) {
                store.remove(selection);

                store.sync({
                    'failure' : function() {
                        store.rejectChanges();
                    }
                });
            }
        }
    },

    onChildGridBeforeRender : function(grid) {
        var store      = grid.getStore(),
            filters    = grid.filters,
            container  = this.getContainer();

        if (Ext.isArray(filters) && !Ext.isEmpty(filters)) {
            Ext.Array.each(filters, function(filter) {
                store.filter(filter.property, container.getViewModel().data.record.get(filter.value));
            });
        }
    },

    onChildGridItemContextMenu : function(grid, record, node, index, e) {
        var me          = this,
            contextMenu = new Ext.menu.Menu({
                plain : true,

                items : [
                    {
                        text : 'Add Record'
                    },
                    {
                        text : 'Delete Selection'
                    }
                ],

                listeners : {
                    click : function(menu, item, e, eOpts) {
                        var store = grid.getStore();

                        if (item.text.match(/Add Record/)) {
                            me.onChildGridCreateClick(store);
                        } else if (item.text.match(/Delete Selection/)) {
                            me.onChildGridDeleteClick(store, grid)
                        }
                    }
                }
            });

        e.stopEvent();
        contextMenu.showAt(e.getXY());
        return false;
    },

    onChildGridCreateClick : function(store) {
        var filters     = store.getFilters(),
            data        = {};

        if (filters.length > 0) {
            if (store.dataDefaults) {
                data = store.dataDefaults;
            }

            data['id'] = '';
            data[filters.items[0].getId()] = filters.items[0].getValue();
            data[filters.items[0].getId().replace('_id','')]    = filters.items[0].getValue();

            store.add(data);
        }
    },

    onChildGridDeleteClick : function(store, grid) {
        var selection = grid.getSelection();

        Ext.Msg.confirm('Delete', 'Are you sure?', function() {
            if (selection.length > 0) {
                store.remove(selection);
            }
        });
    },

    onSyncAndCloseClick : function() {
        if (this.onSyncClick()) {
            this.onCancelClick();
        }
    },

    onSyncClick : function() {
        var formContainer = this.getContainer(),
            form          = formContainer.down('form'),
            store         = formContainer.lookupViewModel(true).getStore(this.getStore()),
            values        = form.getValues(),
            success       = false;

        if (form.isValid()) {
            if (formContainer.createRecord) {
                store.add(values);
            }

            store.sync({
                'failure' : function() {
                    store.rejectChanges();
                },
                'success' : function() {
                    if (formContainer.createRecord) {
                        store.reload();
                    }
                }
            });

            return true;
        }

        return false;
    },

    onCancelClick : function() {
        this.removeContainer();
    }

});
