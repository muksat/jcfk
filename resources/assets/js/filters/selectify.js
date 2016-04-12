Vue.filter('selectify', function (options, nameId, valueId) {
    return options.map(function (item) {

        item.$add('text', item[nameId]);
        item.$add('value', item[valueId]);

        return item;
    });
});