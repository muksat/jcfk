Vue.component('errors', {
    template: require('./../../templates/errors.html'),

    props: ['errors'],

    data: function() {
        return {
            errors: []
        }
    }
});