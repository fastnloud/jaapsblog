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

    onGridDblClick : function(grid, record) {
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

    onCreateClick : function() {
        this.setContainer(this.getView().add({
            xtype : this.getName(),
            title : 'New Record'
        }).show());
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
