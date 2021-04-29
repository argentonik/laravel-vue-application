const mix = require('laravel-mix');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            '@': __dirname + '/resources'
        }
    },
    plugins: [
        new VuetifyLoaderPlugin(),
    ]
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
