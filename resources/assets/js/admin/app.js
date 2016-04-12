window.$ = window.jQuery = require('jquery');
require('bootstrap');
window.Vue = require('vue');
require('vue-resource');
window.VueRouter = require('vue-router');
require('metismenu');
require('./../../../../node_modules/startbootstrap-sb-admin-2/dist/js/sb-admin-2');
require('./../../../../node_modules/jquery-mask-plugin/dist/jquery.mask.min');

require('./../filters/selectify');
require('./../components/geoform');
require('./../components/errors');
require('./../components/grid');
require('./../components/crud');
require('./../components/selectize');

/**
 * Main app components
 */
require('./school');
require('./meal');
require('./student');
require('./teacher');
require('./parent');
require('./user');
require('./teacher');
require('./order-forms');
require('./dayList');


