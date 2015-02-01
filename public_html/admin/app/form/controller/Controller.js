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
        this.getContainer().close();
        this.setContainer(null);
    },

    getChildGridContextMenu : function(grid) {
        var me    = this,
            items = [{text : 'Add Record'}];

        if (grid.getStore().count() > 0) {
            items.push({text : 'Delete Selection'});
        }

        return Ext.create('Ext.menu.Menu', {
            plain       : true,
            alwaysOnTop : true,
            items       : items,

            listeners : {
                click : function(menu, item, e, eOpts) {
                    var store = grid.getStore();

                    if (Ext.isDefined(item)) {
                        if (item.text.match(/Add Record/)) {
                            me.onChildGridCreateClick(store, grid);
                        } else if (item.text.match(/Delete Selection/)) {
                            me.onChildGridDeleteClick(store, grid)
                        }
                    }
                }
            }
        });
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
        var grid        = editor.grid,
            columns     = grid.columns,
            selection   = grid.getSelection()[0];

        if (selection) {
            var data = selection.data;

            Ext.Array.each(columns, function(column) {
                var value = data[column.dataIndex];

                if (Ext.isObject(value) ) {
                    Ext.Object.each(value, function(objectIndex, objectValue) {
                        if (objectIndex == 'id') {
                            data[column.dataIndex] = objectValue;
                        }
                    });
                }
            });
        }
    },

    onChildGridContainerContextMenu : function(grid, e) {
        e.stopEvent();
        this.getChildGridContextMenu(grid).showAt(e.getXY()).focus(null, true);
    },

    onChildGridItemContextMenu : function(grid, record, node, index, e) {
        e.stopEvent();
        this.getChildGridContextMenu(grid).showAt(e.getXY()).focus(null, true);
    },

    onChildGridCreateClick : function(store, grid) {
        var filters = store.getFilters(),
            data    = {};

        if (filters.length > 0) {
            if (store.dataDefaults) {
                data = Ext.clone(store.dataDefaults);

                Ext.Object.each(data, function(index, value) {
                    if (value == 'now()') {
                        data[index] = App.global.Function.getDateTime();
                    }
                });
            }

            data[filters.items[0].getId()] = filters.items[0].getValue();
            data[filters.items[0].getId().replace('_id','')]    = filters.items[0].getValue();

            store.suspendAutoSync();
            store.add(data);
            store.sync({
                'failure' : function() {
                    store.rejectChanges();
                },
                'success' : function(batch) {
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
                        'callback' : function() {
                            store.resumeAutoSync();
                        }
                    });
                }
            }
        });
    },

    onSyncAndCloseClick : function() {
        this.sync(true);
    },

    onSyncClick : function(closeWindow) {
        this.sync(false);
    },

    onCancelClick : function() {
        this.removeContainer();
    },

    sync : function(closeWindow) {
        var me            = this,
            formContainer = me.getContainer(),
            form          = formContainer.down('form'),
            store         = formContainer.lookupViewModel(true).getStore(this.getStore()),
            values        = form.getValues();

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
                'success' : function(batch) {
                    if (closeWindow || formContainer.createRecord) {
                        store.reload();
                        me.onCancelClick();
                    }
                }
            });
        }
    }

});
