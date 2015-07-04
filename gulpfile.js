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

elixir(function(mix) {
    mix.styles([
        'fonts.css',
        'bootstrap.min.css',
        'bootstrap-theme.min.css'
    ]);
    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js'
    ]);
    mix.scripts([
        'html5shiv.min.js',
        'respond.min.js'
    ], 'public/js/ie8.js');
    mix.version([
        'css/all.css',
        'js/all.js',
        'js/ie8.js'
    ]);
});
