new VueCrud({
    el: '#user',
    url: '/admin/user',

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