new Vue({
    el: '#orderForm',
    url: '/parent/order-forms',

    data: {
        students: [],
        orderForms: [],
        submittedForms: []
    },

    ready: function () {
        this.loadData();
    },

    filters: {
        availableStudents: function (students) {
            var availableStudents = [];

            for (var i = 0; students.length > i; i++) {
                if (!this.isStudentSubmitted(students[i].student_id)) {
                    availableStudents.push(students[i]);
                }
            }

            return availableStudents;
        },

        availableForms: function (orderForms, studentId) {
            if (!studentId) {
                return [];
            }

            var student = this.getStudentById(studentId);

            var availableOrderForms = [];

            for (var i = 0; orderForms.length > i; i++) {
                if (student.school_id == orderForms[i].school_id) {
                    availableOrderForms.push(orderForms[i]);
                }
            }

            return availableOrderForms;
        },

        totalPrice: function (submittedForms) {
            var totalPrice = 0;

            for (var i = 0; submittedForms.length > i; i++) {
                totalPrice += submittedForms[i].totalPrice;
            }

            return totalPrice;
        },

        length: function (value) {
            return value.length;
        }
    },

    methods: {
        loadData: function () {
            this.$http.get(this.$options.url + '/load', function (response) {
                this.students = response.students;
                this.orderForms = response.orderForms;
                this.submittedForms = response.cart;
            });
        },

        removeSubmittedForm: function (key) {
            this.$http.post(this.$options.url + '/remove-from-cart', {
                _token: this.token,
                item: this.submittedForms[key]
            });
            this.submittedForms.splice(key, 1);
        },

        isStudentSubmitted: function (studentId) {
            for (var i = 0; this.submittedForms.length > i; i++) {
                if (studentId == this.submittedForms[i].studentId) {
                    return true;
                }
            }

            return false;
        },
        getStudentById: function (studentId) {
            for (var i = 0; this.students.length > i; i++) {
                if (studentId == this.students[i].student_id) {
                    return this.students[i];
                }
            }
        },

        getOrderFormById: function (orderFormId) {
            for (var i = 0; this.orderForms.length > i; i++) {
                if (orderFormId == this.orderForms[i].order_form_id) {
                    return this.orderForms[i];
                }
            }
        },

        addToCart: function (selectedMeals, totalPrice) {
            var item = {
                orderFormId: this.orderFormId,
                meals: selectedMeals,
                studentId: this.student,
                totalPrice: totalPrice
            };

            this.$http.put(this.$options.url + '/add-to-cart', {
                _token: this.token,
                item: item
            });

            this.submittedForms.push(item);

            this.student = null;
            this.orderFormId = null;
        },

        checkout: function () {
            window.location = '/parent/checkout';
        }
    }
});
