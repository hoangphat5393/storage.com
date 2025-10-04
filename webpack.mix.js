const mix = require("laravel-mix");

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

// mix.config.fileLoaderDirs.fonts = "public/assets/fonts";
// mix.config.fileLoaderDirs.images = "public/assets/images";

let productionSourceMaps = false;

mix.sass("resources/sass/style.scss", "public/assets/css")
    .options({
        fileLoaderDirs: {
            images: "assets/images",
            fonts: "assets/fonts",
        },
    })
    .sourceMaps(productionSourceMaps, "source-map");

mix.disableSuccessNotifications();

// mix.then(() => {
//     minifier.minify("public/css/app.css");
// });

// mix.postCss("resources/css/app.css", "public/css");

// mix.setPublicPath('public/')
//     .js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

// mix.styles([
//     'resources/theme/css/font-awesome/all.min.css',
//     'resources/theme/css/flaticon/flaticon.css',
//     'public/theme/plugins/boxicons/css/boxicons.min.css',
//     'resources/theme/css/bootstrap/bootstrap.min.css',
//     'resources/theme/css/select2/select2.css',
//     'resources/theme/css/range-slider/ion.rangeSlider.css',
//     'resources/theme/css/owl-carousel/owl.carousel.min.css',
//     'resources/theme/css/magnific-popup/magnific-popup.css',
//     'public/theme/plugins/datepicker/css/bootstrap-datepicker.min.css',
//     'public/theme/plugins/confirm/jquery-confirm.min.css',
//     'resources/theme/css/animate/animate.min.css',
//     'resources/theme/css/style.css'
// ], 'public/theme/css/styles.expro.min.css');

/*mix.scripts([
    'public/assets/css/style_custom.css',
], 'public/theme/css/style_custom.css').version();

//mix client
mix.scripts([
    'public/assets/js/custom.js',
], 'public/theme/js/custom.js').version();*/

// mix.scripts([
//     'resources/theme/js/jquery-3.6.0.min.js',
//     'resources/theme/js/popper/popper.min.js',
//     'resources/theme/js/bootstrap/bootstrap.min.js',
//     'resources/theme/js/jquery.appear.js',
//     'resources/js/counter/jquery.countTo.js',
//     'resources/theme/js/select2/select2.full.js',
//     'resources/theme/js/range-slider/ion.rangeSlider.min.js',
//     'resources/theme/js/owl-carousel/owl.carousel.min.js',
//     'resources/theme/js/jarallax/jarallax.min.js',
//     'resources/theme/js/jarallax/jarallax-video.min.js',
//     'resources/theme/js/magnific-popup/jquery.magnific-popup.min.js',
//     'public/theme/plugins/jquery.validate.min.js',
//     'public/theme/plugins/datepicker/js/bootstrap-datepicker.min.js',
//     'public/theme/plugins/confirm/jquery-confirm.min.js',
//     'resources/theme/js/axios.min.js',
// ], 'public/theme/js/js.expro.min.js');
