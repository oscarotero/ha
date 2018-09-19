const gulp = require('gulp'),
    path = require('path'),
    sync = require('browser-sync').create(),
    assets = require('browser-assets'),
    url = require('url'),
    PHPServer = require('php-server-manager'),
    postcss = require('gulp-postcss'),
    Terser = require('terser'),
    { Transform } = require('stream'),
    NODE_ENV = process.env.NODE_ENV || 'production';

gulp.task('fonts', () => gulp.src('assets/fonts/*').pipe(gulp.dest('public/fonts')));

gulp.task('css', () => {
    const plugins = [
        require('postcss-import'),
        require('postcss-url'),
        require('postcss-preset-env')({
            browser: '> 0.5%, last 2 versions, Firefox ESR, not dead, not ie',
            stage: 0,
            features: {
                'custom-properties': false
            }
        }),
        require('postcss-extend')
    ];

    if (NODE_ENV === 'production') {
        plugins.push(require('cssnano'));
    }

    return gulp
        .src(['assets/css/styles.css', 'assets/css/reportages/*.css'], { base: 'assets/css' })
        .pipe(postcss(plugins))
        .pipe(gulp.dest('public/css'));
});

gulp.task(
    'js',
    gulp.parallel(
        () => gulp.src('assets/js/**/*.js').pipe(gulp.dest('public/js')),
        () => gulp.src('assets/js/sw.js').pipe(gulp.dest('public')),
        () => assets(['@oom/carousel', '@oom/suggestions', '@oom/page-loader'], 'public/js/vendor'),
        () => assets(['smoothscroll-polyfill', '@webcomponents/custom-elements', 'animejs'], 'public/js/polyfills')
    )
);

gulp.task('js:minify', () =>
    gulp
        .src(['public/js/**/*.js', 'public/sw.js'], { base: 'public' })
        .pipe(
            new Transform({
                objectMode: true,
                transform(file, encoding, done) {
                    const result = Terser.minify(file.contents.toString());
                    file.contents = Buffer.from(result.code);
                    done(null, file);
                }
            })
        )
        .pipe(gulp.dest('public'))
);

gulp.task('img', () => gulp.src('assets/img/**/*.{jpg,png,gif,svg}').pipe(gulp.dest('public/img')));

gulp.task('server', () =>
    PHPServer.start({
        directory: 'public',
        script: 'public/index.php',
        env: {
            APP_URL: 'http://localhost:8000',
            APP_DEV: NODE_ENV === 'development'
        }
    })
);

gulp.task('default', gulp.series('fonts', 'img', 'js', 'js:minify', 'css'));

gulp.task(
    'sync',
    gulp.series('fonts', 'img', 'js', 'css', 'server', () => {
        gulp.watch('assets/**/*.js', gulp.series('js'));
        gulp.watch('assets/**/*.css', gulp.series('css'));
        gulp.watch('assets/**/*.{jpg,png,gif,svg}', gulp.series('img'));
        gulp.watch(['app/**/*', 'templates/**/*'], () => sync.reload());
        gulp.watch('public/**/*').on('change', file => sync.reload(path.basename(file)));

        sync.init({
            reloadOnRestart: true,
            //reloadThrottle: 1000,
            proxy: 'http://localhost:8000',
            open: false
        });
    })
);
