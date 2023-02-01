const mix = require('laravel-mix');
const {postCss} = require("laravel-mix");

mix.js('resources/js/admin/custom.js', 'public/js/admin/custom.js')
    .js('resources/js/user/custom.js', 'public/js/user/custom.js')
    .js('resources/js/user/socket/main.js', 'public/js/user/socket/main.js')
    .css('resources/css/user/style.css', 'public/css/user/style.css')
    .css('resources/css/admin/style.css', 'public/css/admin/style.css')
    .vue()
    .copy('resources/images', 'public/images');
