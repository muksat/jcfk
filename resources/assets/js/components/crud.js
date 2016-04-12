window.VueCrud = Vue.extend({
    ready: function () {
        this.$on('editRow', this.editRow);
        $(this.$$.modal).on('hide.bs.modal', this.resetFields);
    },

    data: function () {
        return {
            fields: {
                _token: null
            },

            errors: []
        }
    },

    methods: {
        onSubmitForm: function (e) {
            e.preventDefault();

            this.$http.put(this.$options.url, this.fields, function () {
                this.errors = [];
                $(this.$$.modal).modal('hide');
                this.$broadcast('formSubmitted');
            }).error(function (data, status, request) {
                this.errors = data;
            });
        },

        updateFields: function (fields) {
            fields._token = this.fields._token;
            this.fields = fields;
        },

        resetFields: function () {
            this.$emit('fieldsReset');
            this.$broadcast('fieldsReset');
            this.updateFields({});
        },

        editRow: function (row) {
            this.updateFields(row);
            $(this.$$.modal).modal();
        }
    }
});