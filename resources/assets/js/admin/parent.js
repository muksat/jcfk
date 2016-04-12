new VueCrud({
    el: '#parent',
    url: '/admin/parent',

    created: function () {
        this.$on('fieldsReset', this.clearPassword);
    },

    data: {
        passwordChange: null
    },

    methods: {
        clearPassword: function () {
            this.passwordChange = null;
        }
    }
});