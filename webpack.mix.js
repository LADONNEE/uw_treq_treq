const mix = require('laravel-mix');
const webpack = require('webpack');
const MomentLocalesPlugin = require('moment-locales-webpack-plugin');


mix.options({
        processCssUrls: false
    })
    .vue({version: 2})
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
        plugins: [
            new MomentLocalesPlugin(),
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                Popper: ['popper.js', 'default'],
                Promise: 'es6-promise-promise'
            }),
        ]
    });
