Ext.define('App.controller.Page', {
    extend  : 'App.controller.Auth',
    views   : ['page.List', 'page.Edit'],
    stores  : ['Page'],
    models  : ['Page'],

    init: function() {
        this.control({
            'pageList': {
                beforerender: this.load,
                itemdblclick: this.updateRecord,
                selectionchange: this.destroyRecord
            },
            'pageList button[action=create]': {
                click: this.insertRecord
            },
            'pageList button[action=destroy]': {
                click: this.destroyRecordHandler
            },
            'pageEdit button[action=update]': {
                click: this.updateRecordHandler
            },
            'pageEdit button[action=update-interim]': {
                click: this.updateRecordHandler
            },
            'pageEdit button[action=create]': {
                click: this.insertRecordHandler
            },
            'pageEdit button[action=create-interim]': {
                click: this.insertRecordHandler
            }
        });
    },

    load: function() {
        this.getPageStore().load();
    },

    destroyRecord: function(sm, selected) {
        sm.view.up().down('button[action=destroy]').setDisabled(!selected.length);
    },

    destroyRecordHandler: function() {
        var grid        = Ext.getCmp('pageList'),
            prompt      = Ext.widget('messagebox'),
            selection   = grid.getSelectionModel().getSelection()[0];

        if (grid.getSelectionModel().hasSelection()) {
            prompt.show({
                title   : 'Delete',
                width   : 200,
                scope   : this,
                msg     : 'Are you sure you want to delete '
                    + '<strong> ' + selection.get('title') + '</strong>?',
                buttons : Ext.Msg.YESNO,
                fn      : function(btn) {
                    if ('yes' === btn) {
                        store = this.getPageStore();
                        store.remove(selection);
                        store.sync();
                    }
                }
            });
        }
    },

    insertRecord: function() {
        var win = Ext.widget('pageEdit');

        win.setTitle('New');
        win.addDocked({
            dock : 'bottom',
            buttons : [
                {text : 'Save', action : 'create'},
                {text : 'Interim save', action : 'create-interim'},
                {text : 'Cancel', scope : win, handler : win.close}
            ]
        });
    },

    insertRecordHandler: function(button) {
        var win    = button.up('window'),
            form   = win.down('form'),
            store  = this.getPageStore(),
            values = form.getValues();

        if (form.isValid()) {
            store.add(values);
            win.close();

            if ('create-interim' == button.action) {
                var record = store.getNewRecords()[0],
                    grid   = Ext.getCmp('pageList');

                store.sync({
                    scope: this,
                    callback : function() {
                        this.updateRecord(grid, record);
                    }
                });
            } else {
                store.sync();
            }
        }
    },

    updateRecord: function(grid, record) {
        var win = Ext.widget('pageEdit');

        win.down('form').loadRecord(record);
        win.addDocked({
            dock : 'bottom',
            buttons : [
                {text : 'Save', action : 'update', handler : win.validate},
                {text : 'Interim save', action : 'update-interim'},
                {text : 'Cancel', scope : win, handler : win.close}
            ]
        });
    },

    updateRecordHandler: function(button) {
        var win    = button.up('window'),
            form   = win.down('form'),
            record = form.getRecord(),
            values = form.getValues();

        if (form.isValid()) {
            record.set(values);
            if ('update-interim' != button.action) {
                win.close();
            }

            this.getPageStore().sync();
        }
    }

});