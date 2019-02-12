let mix = require('laravel-mix')


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

if (!mix.inProduction()) {
  mix.webpackConfig({devtool: 'inline-source-map'})
}

mix
  .js('resources/assets/js/app.js', 'public/js')
   .css('resources/assets/scss/style.js', 'public/css')
  .sourceMaps()



mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
      '@': __dirname + '/resources/assets/admin/js'
    },
  },
})
mix
    .js('resources/assets/admin/js/app.js', 'public/js/admin.js');
