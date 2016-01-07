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
    mix.copy('resources/assets/images/guestbook', 'public/images/guestbook');
    mix.copy('resources/assets/images/gb_animals', 'public/images/gb_animals');
    mix.version([
        'theme/css/all.css',
        'theme/js/all.js',
        'images/guestbook/*.svg',
        'images/gb_animals/*.png'
    ]);
    mix.copy('resources/assets/fonts', 'public/build/theme/fonts');
    mix.copy('resources/assets/images/icons', 'public/theme/images');
});
