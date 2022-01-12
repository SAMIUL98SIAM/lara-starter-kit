const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.js('resources/js/app.js', 'frontend/js')
 .js('resources/js/app.js', 'frontend/js')
 .sass('resources/sass/app.scss', 'frontend/css')
 .sass('resources/sass/frontend.scss', 'frontend/css')
 .sourceMaps();
