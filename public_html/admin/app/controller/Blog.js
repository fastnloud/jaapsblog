Ext.define('App.controller.Blog', {
    extend  : 'App.controller.Auth',
    views   : ['blog.List', 'blog.Edit'],
    stores  : ['Blog','BlogReply'],
    models  : ['Blog'],

    init: function() {
        this.control({
            'blogList': {
                beforerender: this.load,
                itemdblclick: this.updateRecord,
                selectionchange: this.destroyRecord
            },
            'blogList button[action=create]': {
                click: this.insertRecord
            },
            'blogList button[action=destroy]': {
                click: this.destroyRecordHandler
            },
            'blogEdit button[action=update]': {
                click: this.updateRecordHandler
            },
            'blogEdit button[action=update-interim]': {
                click: this.updateRecordHandler
            },
            'blogEdit button[action=create]': {
                click: this.insertRecordHandler
            }
        });
    },

    load: function() {
        this.getBlogStore().load();
    },

    destroyRecord: function(sm, selected) {
        sm.view.up().down('button[action=destroy]').setDisabled(!selected.length);
    },

    destroyRecordHandler: function() {
        var grid        = Ext.getCmp('blogList'),
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
                        store = this.getBlogStore();
                        store.remove(selection);
                        store.sync({
                            scope: this,
                            callback : function() {
                                this.getBlogReplyStore().reload();
                            }
                        });
                    }
                }
            });
        }
    },

    insertRecord: function() {
        var win = Ext.widget('blogEdit');

        win.setTitle('New');
        win.addDocked({
            dock : 'bottom',
            buttons : [
                {text : 'Save', action : 'create'},
                {text : 'Cancel', scope : win, handler : win.close}
            ]
        });
    },

    insertRecordHandler: function(button) {
        var win    = button.up('window'),
            form   = win.down('form'),
            store  = this.getBlogStore(),
            values = form.getValues();

        if (form.isValid()) {
            store.add(values);
            win.close();
        }
    },

    updateRecord: function(grid, record) {
        var win = Ext.widget('blogEdit');

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

            this.getBlogStore().sync();
        }
    }

});