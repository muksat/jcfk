Vue.component('order-day-list', {
    template: require('./../../templates/orderDayList.html'),
    url: '/parent/order-forms/days',

    props: ['order-form-id', 'add-to-cart'],

    data: function () {
        return {
            orderFormId: null,
            days: [],
            mealPrice: 0,
            selectedMeals: []
        }
    },

    ready: function () {
        this.$watch('orderFormId', function (orderFormId) {
            if (!orderFormId) {
                this.days = [];
                this.selectedMeals = [];
                return;
            }

            this.fetchDays();
        });
    },

    methods: {
        fetchDays: function () {
            this.$http.get(this.$options.url + '/' + this.orderFormId, function (response) {
                this.days = response.days;
                this.mealPrice = response.meal_price;
            });
        },

        selectMeal: function (day, meal, event) {
            for (var i = 0; this.selectedMeals.length > i; i++) {
                if (day.short_date == this.selectedMeals[i].day) {
                    $(event.target).parent().find('li').removeClass('meal-selected');

                    if (meal.meal_id == this.selectedMeals[i].meal_id) {
                        this.selectedMeals.splice(i, 1);
                        return;
                    }
                    this.selectedMeals.splice(i, 1);
                }
            }

            this.selectedMeals.push({
                meal_id: meal.meal_id,
                day: day.short_date
            });


            $(event.target).addClass('meal-selected');
        }
    }
});