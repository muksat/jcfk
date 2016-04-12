require('./day');


new Vue({
    el: '#dayList',
    url: '/admin/order-forms/days',
    orderFormsUrl: '/admin/order-forms',

    data: {
        orderFormId: null,
        days: []
    },

    ready: function () {
        this.fetchDays();
    },

    methods: {
        fetchDays: function () {
            this.$http.get(this.$options.url + '/list/' + this.orderFormId, function (days) {
                this.days = days;
            });
        },

        publishOrderForm: function () {
            this.$http.get(this.$options.orderFormsUrl + '/publish/' + this.orderFormId, function () {
                window.location = this.$options.orderFormsUrl;
            });
        }
    }
});