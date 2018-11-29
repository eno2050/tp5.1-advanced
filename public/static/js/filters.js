Vue.filter('defaultVal', function (value) {
    if (value == '0') {
        return '';
    } else {
        return value;
    }
});