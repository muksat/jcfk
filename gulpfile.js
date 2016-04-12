var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

var bootstrapPath = __dirname + '/node_modules/bootstrap/';
var fontAwesomePath = __dirname + '/node_modules/font-awesome/';


/**
 * Admin
 */
elixir(function(mix) {
 mix.less('admin/app.less', 'public/css/admin', {
     paths: [
         bootstrapPath + 'less',
         fontAwesomePath + 'less',
         __dirname + '/node_modules/startbootstrap-sb-admin-2/less',
         __dirname + '/node_modules/selectize/dist/less'
     ]
 })
     .styles([
         '/node_modules/metismenu/dist/metisMenu.min.css',
         'public/css/admin/app.css'
     ], 'public/css/admin/app.css', './');


    mix.copy(bootstrapPath + 'fonts/**', 'public/fonts');

    mix.copy(fontAwesomePath + 'fonts/**', 'public/fonts');

    mix.browserify('admin/app.js', 'public/js/admin/bundle.js');
});


/**
 * Blank
 */
elixir(function(mix) {
    mix.less('blank.less', 'public/css/blank.css', {
        paths: [
            bootstrapPath + 'less'
        ]
    });
});

/**
 * Parents
 */
elixir(function(mix) {
    mix.less('parent/app.less', 'public/css/parent/app.css', {
        paths: [
            bootstrapPath + 'less',
            fontAwesomePath + 'less',
            __dirname + '/node_modules/startbootstrap-sb-admin-2/less',
            __dirname + '/node_modules/selectize/dist/less'
        ]
    })
        .styles([
            '/node_modules/metismenu/dist/metisMenu.min.css',
            'public/css/parent/app.css'
        ], 'public/css/parent/app.css', './');

    mix.browserify('parent/app.js', 'public/js/parent/bundle.js');
});