const gulp = require('gulp'),
    sass = require('gulp-sass')(require('sass')),
    concat = require('gulp-concat'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),
    rename = require('gulp-rename'),
    uglify = require('gulp-uglify'),
    sourcemaps = require('gulp-sourcemaps'),
    browserSync = require('browser-sync').create(),
    fs = require('fs'),
    axios = require('axios').default,
    purgecss = require('gulp-purgecss'),
    config = require('./gulp.config'),
    webpages = config.webpages;

async function download_webpages(cb) {
    // Make a request for a user with a given ID
    for (let page in webpages) {
        try {
            const resp = await axios.get('https://www.kahoycrafts.com' + webpages[page].path);

            fs.writeFile(`assets/src/downloads/${webpages[page].name}.html`, resp.data, function(err) {
                if (err) {
                    return console.log(err);
                }
            }); 
        } 
        catch (err) {
            console.log(err);
        }
    }
    cb();
}

function purge_theme_styles() {
    return gulp.src([
        '../../plugins/woocommerce/assets/css/twenty-twenty-one.css',
        '../../plugins/jetpack/modules/theme-tools/compat/twentytwentyone.css',
        '../twentytwentyone/style.css'
      ])
      .pipe(purgecss({
          content: ['assets/src/downloads/**/*.html'],
          safelist: {
            standard: ['onsale', 'variations', 'woocommerce-variation-price', 'widget'],
            deep: [
                /^woocommerce-product-gallery/, 
                /^primary-navigation/, 
                /^wp-custom-logo/, 
                /^site-header/, 
                /^site-logo/, 
                /^site-branding/
            ]
          },
          rejected: false
      }))
      .pipe(concat('twentytwentyone.css'))
      .pipe(gulp.dest('assets/src/purge-css/'));
}

function purge_block_styles() {
    return gulp.src([
        '../../../wp-includes/css/dist/block-library/style.css',
        '../../plugins/woocommerce/assets/css/woocommerce-layout.css',
        '../../plugins/woocommerce/assets/css/woocommerce-smallscreen.css',
        '../../plugins/woocommerce/packages/woocommerce-blocks/build/wc-blocks-vendors-style.css',
        '../../plugins/woocommerce/packages/woocommerce-blocks/build/wc-blocks-style.css',
        'assets/src/fontawesome/css/fontawesome.css'
      ])
      .pipe(purgecss({
          content: ['assets/src/downloads/**/*.html'],
          safelist: {
            standard: ['onsale']
          },
          rejected: false
      }))
      .pipe(gulp.dest('assets/src/purge-css/'));
}

function js() {
  return gulp.src('./assets/src/js/**/*.js')
    .pipe(uglify())
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write('./maps', {
        sourceRoot: '../src/js'
    }))
    .pipe(rename(function(path) {
        if (! path.extname.endsWith('.map') ) {
            path.extname = ".min.js";
        }
    }))
    .pipe(gulp.dest('./assets/js/'))
    .pipe(browserSync.stream());
};

function css() {
  return gulp.src('./assets/src/scss/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(cleanCSS({compatibility: '*'}))
    .pipe(sourcemaps.write('.', {
        includeContent: false,
        sourceRoot: '../src/scss'
    }))
    .pipe(rename(function(path) {
        if (! path.extname.endsWith('.map') ) {
            path.extname = ".min.css";
        }
    }))
    .pipe(gulp.dest('./assets/css/'))      
    .pipe(browserSync.stream());
};

function serve() {
  browserSync.init({
    injectChanges: true,
    files: [
        './assets/js/**/*.js',
        './assets/css/**/*.css'
    ],
    proxy: {
        target: "http://kahoycrafts.test/"
    }
  });
};

function watch() {
    gulp.watch('./assets/src/scss/**/*.scss', { ignoreInitial: false }, css);
    gulp.watch('./assets/src/js/**/*.js', { ignoreInitial: false }, js);
}

exports.download = download_webpages;

exports.purge = gulp.series(purge_theme_styles, purge_block_styles);

exports.build = gulp.parallel(css, js);

exports.watch = gulp.parallel(watch);

exports.default = gulp.parallel(watch, serve);
