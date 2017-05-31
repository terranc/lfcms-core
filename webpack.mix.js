const { mix } = require('laravel-mix');

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
    module: {
      rules: [
        {
          exclude: /node_modules/,
          loader: 'eslint-loader',
          test: /\.(js|vue)?$/
        },
      ]
    }
  })
  .js('resources/assets/js/app.js', 'public/js')
  .js('resources/assets/js/frame.js', 'public/js')
  .less('resources/assets/less/app.less', 'public/css')
  .less('resources/assets/less/frame.less', 'public/css')
    .options({
        processCssUrls: false
    });
