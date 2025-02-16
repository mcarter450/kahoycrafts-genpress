import gulp from 'gulp';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import concat from 'gulp-concat';
import autoprefixer from 'gulp-autoprefixer';
import cleanCSS from 'gulp-clean-css';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';
import sourcemaps from 'gulp-sourcemaps';
import browserSyncImport from 'browser-sync';
import config from './gulp.config.js'
import fs from 'fs';
import axios from 'axios';
import purgecss from 'gulp-purgecss';

const sass = gulpSass(dartSass),
      browserSync = browserSyncImport.create();

async function download_webpages(cb) {
    // Make a request for a user with a given ID
    const webpages = config.webpages;

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

function purge_fontawesome_styles() {
    return gulp.src([
        'assets/src/scss/purge-styles/fontawesome.scss'
      ])
      .pipe(sass().on('error', sass.logError))
      .pipe(purgecss({
          content: ['assets/src/downloads/**/*.html'],
          rejected: false
      }))
      .pipe(gulp.dest('assets/src/purge-css/'));
}

function purge_general_styles() {
    return gulp.src([
        '../../../wp-includes/css/dist/block-library/style.css',
        '../../plugins/woocommerce/assets/client/blocks/wc-blocks.css',
        '../../plugins/woocommerce/assets/client/blocks/all-products.css'
      ])
      .pipe(purgecss({
          content: ['assets/src/downloads/**/*.html'],
          safelist: {
            standard: ['onsale'],
            deep: [
                /flex-control-thumbs$/,
                /variations$/,
                /woocommerce-product-gallery__trigger$/
            ],
            //greedy: []
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
    .pipe(cleanCSS({
        compatibility: '*',
        level: {
            1: {
                tidySelectors: false
            }
        }
    }))
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

export const download = download_webpages;

export const purge = gulp.series(purge_fontawesome_styles, purge_general_styles);

export const build = gulp.parallel(css, js);

export { watch as watch };

const sync = gulp.parallel(watch, serve);

export default sync;
