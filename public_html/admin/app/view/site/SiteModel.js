Ext.define('App.view.site.SiteModel', {
    extend  : 'Ext.app.ViewModel',
    alias   : 'viewmodel.site',

    stores : {
        site : {
            autoLoad : true,

            sorters : [{
                property  : 'date',
                direction : 'DESC'
            }],

            fields : [
                'id',
                'title',
                'domain',
                {
                    name     : 'status',
                    sortType : function(value) {
                        return value.label;
                    }
                }
            ],

            proxy : {
                type : 'ajax',
                url  : '/admin/site',

                api: {
                    read    : '/admin/site/read',
                    update  : '/admin/site/update',
                    create  : '/admin/site/create',
                    destroy : '/admin/site/destroy'
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
