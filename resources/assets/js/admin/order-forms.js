Vue.directive("date", {
    "twoWay": true,
    "bind": function () {
        var self = this;

        self.mask = "99/99/9999";
        $(self.el).mask(self.mask, { placeholder:"MM/DD/YYYY" });
        $(self.el).change(function() {
            var value = $(this).val();
            self.set(value);
        });
    },
    "unbind": function () {
        var self = this;

        $(self.el).unmask(self.mask);
    }
});

new VueCrud({
    el: '#orderForms',
    url: '/admin/order-forms',
    computed: {
        orderFormActions: function () {
            return [
                {
                    btnClass: 'btn-success',
                    callBack: this.editFormDays,
                    name: 'Edit days'
                }
            ];
        }
    },

    methods: {
        showRowActions: function (row) {
            return !row.is_published;
        },
        editFormDays: function (row) {
            window.location = '/admin/order-forms/days/' + row.order_form_id;
        }
    }
});