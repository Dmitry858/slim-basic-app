let mix = require('laravel-mix');

mix.options({ manifest: false });

mix.js('resources/js/app.js', 'js').setPublicPath('public');
mix.sass('resources/sass/app.sass', 'css').setPublicPath('public');