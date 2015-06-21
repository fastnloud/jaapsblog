Ext.define('App.view.page.PageModel', {
    extend  : 'Ext.app.ViewModel',
    alias   : 'viewmodel.page',

    stores : {
        page : {
            autoLoad : true,

            sorters : [{
                property  : 'priority',
                direction : 'ASC'
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
                'priority'
            ],

            proxy : {
                type : 'ajax',
                url  : '/admin/page',

                api : {
                    read    : '/admin/page/read',
                    update  : '/admin/page/update',
                    create  : '/admin/page/create',
                    destroy : '/admin/page/destroy'
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
