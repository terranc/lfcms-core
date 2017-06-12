const {mix} = require('laravel-mix');
const path = require('path');

function resolve(dir) {
    return path.join(__dirname, '..', dir)
}
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
// mix.disableNotifications();
mix.webpackConfig({
    resolve: {
        // mainFields: ['jsnext:main', 'main'],
        extensions: ['.js', '.vue', '.json'],
        alias: {
            'assets': resolve('resources/assets'),
            'js': resolve('resources/assets/js'),
            'css': resolve('resources/assets/css'),
            'sass': resolve('resources/assets/sass'),
            'images': resolve('resources/assets/images'),
            'components': resolve('resources/assets/js/components'),
        }
    },
    externals: {
        "vue": "Vue",
        "jquery": "jQuery",
        "axios": "axios"
    },
    module: {
        noParse: /node_modules\/(jquey|chart\.js)/,  // 哪些文件可以脱离webpack的解析
        rules: [
            {
                exclude: /node_modules/,
                loader: 'eslint-loader',
                test: /\.(js|vue)?$/
            },
        ]
    }
})
        .js('resources/assets/js/app.js', 'public/js').extract([
            'jquery',
            'bootstrap-notify',
            'jquery-query-object',
            'bootstrap-editable',
            'jquery-easy-loading/dist/jquery.loading',
            'select2/dist/js/select2',
            'select2/dist/js/i18n/zh-CN',
            'eonasdan-bootstrap-datetimepicker',
            'dom-form-serializer',
        ])
        .sass('resources/assets/sass/app.scss', 'public/css')
        .options({
            processCssUrls: false
        }).compress().version();
