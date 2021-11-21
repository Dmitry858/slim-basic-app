let mix = require('laravel-mix');

mix.options({ manifest: false });

mix.js('resources/js/bootstrap.js', 'js').setPublicPath('public');
mix.js('resources/js/app.js', 'js').setPublicPath('public');
mix.sass('resources/scss/bootstrap.scss', 'css').setPublicPath('public');
mix.sass('resources/scss/app.scss', 'css').setPublicPath('public');