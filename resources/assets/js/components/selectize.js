require('selectize');

Vue.component('selectize', {
    template: require('./../../templates/selectize.html'),

    props: [
        'url',
        'valueField',
        'searchField',
        'label',
        'placeholder',
        'id',
        'value'
    ],

    created: function () {
        this.$on('fieldsReset', this.clearSelectize);
    },

    data: function() {
        return {
            selectize: null,
            url: null,
            valueField: null,
            searchField: null,
            value: null
        }
    },

    ready: function () {
        var selectize = $('#' + this.id).selectize({
            valueField: this.valueField,
            labelField: this.searchField,
            searchField: this.searchField,
            onChange: this.setValue,
            create: false,
            load: this.search
        });

        this.selectize = selectize[0].selectize;

        if (this.value != null) {
            this.loadByKey(this.value);
        }

        this.$watch('value', function (value) {
            if (value != this.selectize.items[0] && typeof value != 'undefined' && value != null) {
                this.loadByKey(value);
            }
        }).bind(this);
    },

    methods: {
        search: function (query, callback) {
            this.$http.get(this.url + '/' + encodeURIComponent(query), function (response) {
                callback(response);
            });
        },

        loadByKey: function (value) {
            this.$http.get(this.url + '/load/' + value, function (response) {
                this.selectize.addOption(response);
                this.selectize.refreshOptions();
                this.selectize.setValue(response[this.valueField], true);
            });
        },

        setValue: function () {
            this.value = this.selectize.items[0];
        },

        clearSelectize: function() {
            this.selectize.clearOptions(true);
            this.selectize.clear(true);
        }
    }
});