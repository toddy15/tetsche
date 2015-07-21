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
    ], 'public/theme/css');
    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js'
    ], 'public/theme/js');
    mix.scripts([
        'html5shiv.min.js',
        'respond.min.js'
    ], 'public/theme/js/ie8.js');
    mix.copy('resources/assets/images/guestbook', 'public/images/guestbook');
    mix.version([
        'theme/css/all.css',
        'theme/js/all.js',
        'theme/js/ie8.js',
        'images/guestbook/*.svg'
    ]);
    mix.copy('resources/assets/fonts', 'public/build/theme/fonts');
    mix.copy('resources/assets/images', 'public/theme/images');
});
