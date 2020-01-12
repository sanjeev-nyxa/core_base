let mix = require('laravel-mix');
const PathOverridePlugin = require('path-override-webpack-plugin');
const fs = require('fs');
const collect = require('collect.js');
// const Modules = require('./modules/');

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
let Modules = collect();
fs.readdirSync('./plugins/').forEach(module => {
    let path = './plugins/' + module + '/module.json';
    if (fs.existsSync(path)) {
        let conf = require(path);
        if (conf.active) {
            Modules.push(conf)
        }
    }
});

const APP_NAME = 'labs';
let aliases = {
    '@labs': path.resolve('./plugins')
};

let plugins = [];

Modules.sortBy(module => module.order).map(module => {
    aliases["@labs-" + module.alias] = path.resolve('./plugins/' + module.name + '/Resources/assets');
    aliases["@labs-" + module.alias] = path.resolve('./plugins/' + module.name + '/Resources/assets');
    plugins.push(new PathOverridePlugin(new RegExp('@labs-' + module.alias), path.resolve('./resources/assets/' + APP_NAME + '/' + module.alias)));
});


mix.webpackConfig({
    resolve: {
        alias: aliases
    },
    plugins: plugins
});


mix.js('resources/assets/admin/main.js', 'public/admin/js/app.js')
    .stylus('resources/assets/admin/main.styl', 'public/admin/css/app.css')
    .version();

