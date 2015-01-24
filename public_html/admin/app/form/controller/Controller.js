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
                deleteButton  = this.getView().lookupReference('mainGridDeleteButton'),
                store         = grid.lookupViewModel(true).getStore(this.getStore()),
                selection     = grid.getSelection();

            if (selection.length > 0) {
                store.remove(selection);

                store.sync({
                    'success' : function() {
                        deleteButton.disable();
                    },
                    'failure' : function() {
                        store.rejectChanges();
                    }
                });
            }
        }
    },

    getChildGridContextMenu : function(grid) {
        var me    = this,
            items = [{text : 'Add Record'}];

        if (grid.getStore().count() > 0) {
            items.push({text : 'Delete Selection'});
        }

        return new Ext.menu.Menu({
            plain : true,

            items : items,

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
    },

    onChildGridBeforeRender : function(grid) {
        var store       = grid.getStore(),
            filters     = grid.filters,
            container   = this.getContainer();

        if (Ext.isEmpty(container.getViewModel().data.record)){
            grid.disable(true);
        }

        if (Ext.isArray(filters) && !Ext.isEmpty(filters)) {
            Ext.Array.each(filters, function(filter) {
                if (!grid.isDisabled()) {
                    store.filter(filter.property, container.getViewModel().data.record.get(filter.value));
                } else {
                    store.filter(filter.property, 0);
                }
            });
        }
    },

    onChildGridBeforeEdit : function(editor, context) {
        if (Ext.isObject(context.value)) {
            Ext.Object.each(context.value, function(index, value) {
                if (index != 'id') {
                    context.value = value;
                }
            });
        }
    },

    onChildGridContainerContextMenu : function(grid, e) {
        e.stopEvent();
        this.getChildGridContextMenu(grid).showAt(e.getXY());

        return false;
    },

    onChildGridItemContextMenu : function(grid, record, node, index, e) {
        e.stopEvent();
        this.getChildGridContextMenu(grid).showAt(e.getXY());

        return false;
    },

    onChildGridCreateClick : function(store) {
        var filters     = store.getFilters(),
            data        = {};

        if (filters.length > 0) {
            if (store.dataDefaults) {
                data = Ext.clone(store.dataDefaults);

                Ext.Object.each(data, function(index, value) {
                    if (value == 'now()') {
                        data[index] = App.global.Function.getDateTime();
                    }
                });
            }

            data['id'] = '';
            data[filters.items[0].getId()] = filters.items[0].getValue();
            data[filters.items[0].getId().replace('_id','')]    = filters.items[0].getValue();

            store.suspendAutoSync();
            store.add(data);
            store.sync({
                'failure' : function() {
                    store.rejectChanges();
                },
                'success' : function() {
                    store.reload();
                },
                'callback' : function() {
                    store.resumeAutoSync();
                }
            });
        }
    },

    onChildGridDeleteClick : function(store, grid) {
        var selection = grid.getSelection();

        Ext.Msg.confirm('Delete', 'Are you sure?', function(choice) {
            if (choice === 'yes') {
                if (selection.length > 0) {
                    store.suspendAutoSync();
                    store.remove(selection);
                    store.sync({
                        'failure' : function() {
                            store.rejectChanges();
                        },
                        'success' : function() {
                            store.reload();
                        },
                        'callback' : function() {
                            store.resumeAutoSync();
                        }
                    });
                }
            }
        });
    },

    onSyncAndCloseClick : function() {
        if (this.onSyncClick()) {
            this.onCancelClick();
        }
    },

    onSyncClick : function() {
        var me            = this,
            formContainer = me.getContainer(),
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
                    Ext.Msg.alert('Error', 'Request could not be processed.', function() {
                        store.rejectChanges();
                    });
                },
                'success' : function(record) {
                    if (formContainer.createRecord) {
                        store.reload();
                        me.onCancelClick();
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
