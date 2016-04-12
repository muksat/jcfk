Vue.component('day', {
    template: require('./../../templates/admin-day.html'),
    url: '/admin/order-forms/days',

    props: ['token'],

    data: function () {
        return {
            orderFormId: null,
            showMealSearchBox: null,
            newMealId: null,
            days: []
        }
    },

    ready: function () {
        this.$watch('newMealId', this.addMeal);
    },

    methods: {
        showSelectize: function () {
            this.showMealSearchBox = true;
        },

        deleteMeal: function (mealId) {
            this.$http.post(this.$options.url, this.createRequestData(mealId));

            for (var i = 0; i < this.day.meals.length; i++) {
                if (this.day.meals[i].meal_id == mealId) {
                    this.day.meals.splice(i, 1);
                }
            }
        },

        addMeal: function (mealId) {
            if (!this.validateMeal(mealId)) {
                this.$broadcast('fieldsReset');
                return;
            }

            this.$http.put(this.$options.url, this.createRequestData(mealId), function (meal) {
                this.day.meals.push(meal);
            });

            this.showMealSearchBox = false;

            this.$broadcast('fieldsReset');
        },

        createRequestData: function (mealId) {
            return {
                meal_id: mealId,
                order_form_id: this.day.order_form_id,
                date: this.day.short_date,
                _token: this.token
            };
        },

        validateMeal: function (mealId) {
            if (!mealId) {
                return false;
            }

            for (var i = 0; i < this.day.meals.length; i++) {
                if (this.day.meals[i].meal_id == mealId) {
                    return false;
                }
            }

            return true;
        }
    }
});