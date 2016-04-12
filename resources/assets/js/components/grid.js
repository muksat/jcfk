Vue.component('grid', {
    template: require('./../../templates/grid.html'),
    replace: true,
    props: ['url', 'actions', 'no-actions', 'row-actions'],
    data: function () {
        return {
            data: null,
            columns: null,
            actions: [],
            sortKey: '',
            url: null,
            pk: null,
            reversed: {},
            lastPage: null,
            currentPage: 1
        }
    },
    created: function () {
        this.$on('formSubmitted', function() {
            this.fetchSchools();
        });
    },
    compiled: function () {
        this.fetchSchools();

        this.$watch('currentPage', function () {
            this.fetchSchools();
        }).bind(this);
    },
    methods: {
        showRowActions: function (row) {
            if (typeof this.rowActions == 'undefined') {
                return true;
            }

            return this.rowActions(row);
        },
        sortBy: function (key) {
            this.sortKey = key;
            this.reversed[key] = !this.reversed[key];
        },
        columnsInit: function (columns) {
            var self = this;
            this.columns = columns;
            columns.forEach(function (key) {
                self.reversed.$add(key, false)
            })
        },
        switchPage: function(event, newPage) {
            event.preventDefault();

            this.currentPage = newPage;
        },
        fetchSchools: function () {
            this.$http.get(this.url + '/list?page=' + this.currentPage, function (response) {

                if (this.columns == null) {
                    this.columnsInit(response.columns);
                }

                this.data = response.data;
                this.currentPage = response.current_page;
                this.lastPage = response.last_page;
                this.pk = response.pk;
            });
        },
        editRow: function (row) {
            this.$http.get(this.url + '/' + row[this.pk], function (response) {
                this.$dispatch('editRow', response);
            });
        },

        deleteRow: function (row, event) {
            if(!confirm('Are you sure?')) {
                return;
            }
            $(event.target).parent().parent().remove();
            this.$http.get(this.url + '/delete/' + row[this.pk], function () {
                this.fetchSchools();
            });
        }
    },

    filters: {
        toColumn: function (column) {
            return column.replace('_', ' ');
        }
    }
});