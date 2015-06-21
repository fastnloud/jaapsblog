Ext.define('App.view.blog.BlogModel', {
    extend  : 'Ext.app.ViewModel',
    alias   : 'viewmodel.blog',

    stores : {
        blog : {
            autoLoad : true,

            sorters : [{
                property  : 'date',
                direction : 'DESC'
            }],

            fields : [
                'id',
                'title',
                'slug',
                {
                    name     : 'status',
                    sortType : function(value) {
                        return value.label;
                    }
                },
                {
                    name    : 'date',
                    mapping : 'date.date'
                }
            ],

            proxy : {
                type : 'ajax',
                url  : '/admin/blog',

                api : {
                    read    : '/admin/blog/read',
                    update  : '/admin/blog/update',
                    create  : '/admin/blog/create',
                    destroy : '/admin/blog/destroy'
                },

                reader : {
                    type            : 'json',
                    rootProperty    : 'data'
                },

                writer : {
                    type            : 'json',
                    rootProperty    : 'data',
                    encode          : true
                }
            }
        }
    }
});
