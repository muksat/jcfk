Vue.component('geoform', {
    template: require('./../../templates/geoform.html'),

    props: ['city-id', 'region'],

    data: function() {
        return {
            country: 'CA',
            region: 'ON',
            cityId: null,
            regions: [],
            cities: []
        }
    },

    ready: function() {

        this.fetchRegions();

        this.$watch('region', function (region) {
            this.fetchCitiesByRegion(region);
        }).bind(this);

        if (this.region) {
            this.fetchCitiesByRegion(this.region);
        }
    },

    methods: {
        fetchRegions: function() {
            this.$http.get('/geo/regions?countryCode=CA', function(regions) {
                this.$set('regions', regions);
            });
        },

        fetchCitiesByRegion: function(region) {
            if (region == null) {
                this.cities = [];
                return;
            }
            this.$http.get('/geo/cities?regionCode=' + region, function(cities) {
                this.$set('cities', cities);
            });
        }
    }
});