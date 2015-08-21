// Javascript Task Runner
'use strict';

var gulp = require('gulp');

function handleError() {
    console.log('error');
    this.emit('end');
}

// Refresh browser on changes
gulp.task('browsersync', function() {
    var browserSync = require('browser-sync');

    browserSync.init({
        proxy: "spacexstats.dev"
    });
});

// Clean media folder occasionally
gulp.task('clean', function() {
    var del = require('del');
    del(['public/media/small/*', 'public/media/large/*', 'public/media/full/*', 'public/media/twitter/*',
    '!public/media/**/audio.png']);
});

// Scripts Task. Concat and minify.
gulp.task('scripts', function() {
    var uglify = require('gulp-uglify');
    var concat = require('gulp-concat');

    gulp.src('frontendapp/js/angular/**/*.js')
        .pipe(concat('app.js'))
        .pipe(uglify()).on('error', handleError)
        .pipe(gulp.dest('public/js'));

    gulp.src('frontendapp/src/js/lib/**/*.js')
        .pipe(gulp.dest('public/js'));
});

// Styles task. Compile all the styles together, autoprefix them, and convert them from SASS to CSS
gulp.task('styles', function() {
    var autoprefixer = require('gulp-autoprefixer');
    var sass = require('gulp-sass');

    gulp.src('frontendapp/css/styles.scss')
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest('public/css'));
});

// Images Task. Minify all images in the src/images folder using imagemin
gulp.task('images', function() {
    var imagemin = require('gulp-imagemin');

    gulp.src('frontendapp/images/**/*.{jpg,jpeg,png}')
        .pipe(imagemin())
        .pipe(gulp.dest('public/images'));
});

// Fonts Task.
gulp.task('fonts', function() {
   gulp.src('frontendapp/fonts/*')
       .pipe(gulp.dest('public/fonts'));
});

// Watch task. Watch for changes automatically and recompile the SASS.
gulp.task('watch', function() {
    gulp.watch('frontendapp/css/**/*.scss', ['styles']);
    gulp.watch('frontendapp/js/**/*.*', ['scripts']);
});

gulp.task('default', ['styles', 'watch', 'browsersync']);