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

    gulp.src('public/src/js/angular/**/*.js')
        .pipe(concat('app.js'))
        //.pipe(uglify()).on('error', handleError)
        .pipe(gulp.dest('public/dest/js'));
});

// Styles task. Compile all the styles together, autoprefix them, and convert them from SASS to CSS
gulp.task('styles', function() {
    var autoprefixer = require('gulp-autoprefixer');
    var sass = require('gulp-sass');

    gulp.src('public/src/css/styles.scss')
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest('public/dest/css'));
});

// Images Task. Minify all images in the src/images folder using imagemin
gulp.task('images', function() {
    var imagemin = require('gulp-imagemin');

    gulp.src('public/src/images/**/*.{jpg,jpeg,png}')
        .pipe(imagemin())
        .pipe(gulp.dest('public/dest/images'));
});

// Fonts Task.
gulp.task('fonts', function() {
   gulp.src('public/src/fonts/*')
       .pipe(gulp.dest('public/dest/fonts'));
});

// Watch task. Watch for changes automatically and recompile the SASS.
gulp.task('watch', function() {
    gulp.watch('public/src/css/**/*.scss', ['styles']);
    gulp.watch('public/src/js/**/*.*', ['scripts']);
});

gulp.task('default', ['styles', 'watch', 'browsersync']);