Ext.define('App.controller.BlogReply', {
    extend  : 'App.controller.Auth',
    views   : ['blog.Reply'],
    stores  : ['BlogReply'],
    models  : ['BlogReply'],

    init: function() {
        this.control({
            'blogList': {
                beforerender: this.load,
                selectionchange : this.updateGrid
            },
            'blogReply' : {
                edit: this.edit,
                selectionchange: this.destroyRecord
            },
            'blogReply button[action=create]': {
                click: this.insertRecord
            },
            'blogReply button[action=destroy]': {
                click: this.destroyRecordHandler
            }
        });
    },

    load: function() {
        this.getBlogReplyStore().load();
    },

    edit: function(editor, e) {
        var record = e.record,
            store  = this.getBlogReplyStore();

        if (!record.get('id')) {
            if ('' != record.get('name') && '' != record.get('comment')) {
                store.sync({
                    scope: store,
                    callback : function() {
                        this.reload();
                    }
                });
            }
        } else {
            store.update(record);
        }
    },

    updateGrid: function(sm) {
        var store = this.getBlogReplyStore(),
            view  = Ext.getCmp('blogReply');

        if (sm.hasSelection()) {
            store.clearFilter();
            store.filter('id_blog', sm.getSelection()[0].get('id'));

            view.down('button[action=create]').setDisabled(false);
        } else {
            view.down('button[action=create]').setDisabled(true);
        }
    },

    destroyRecord: function(sm, selected) {
        sm.view.up().down('button[action=destroy]').setDisabled(!selected.length);
    },

    destroyRecordHandler: function() {
        var grid        = Ext.getCmp('blogReply'),
            prompt      = Ext.widget('messagebox'),
            selection   = grid.getSelectionModel().getSelection()[0];

        if (grid.getSelectionModel().hasSelection()) {
            prompt.show({
                title   : 'Delete',
                width   : 200,
                scope   : this,
                msg     : 'Are you sure you want to delete '
                    + '<strong> ' + selection.get('name') + ' ('+ selection.get('timestamp') +')</strong>?',
                buttons : Ext.Msg.YESNO,
                fn      : function(btn) {
                    if ('yes' === btn) {
                        store = this.getBlogReplyStore();
                        store.remove(selection);
                        store.sync();
                    }
                }
            });
        }
    },

    insertRecord: function() {
        var store = this.getBlogReplyStore();
        var reply = new Ext.create('App.model.BlogReply', {
            id : '',
            id_blog : store.filters.items[0].value,
            name: '',
            comment: '',
            is_admin: true,
            timestamp: null
        });

        if (null === store.getById('')) {
            store.add(reply);
        }
    }

});