// Javascript Task Runner
'use strict';

var gulp = require('gulp');
var browserSync = require('browser-sync').create();

function handleError(error) {
    console.log(error);
    this.emit('end');
}

// Refresh browser on changes
gulp.task('browsersync', function(gulpCallback) {
    browserSync.init({
        proxy: "spacexstats.app"
    }, function callback() {

        gulp.watch('resources/assets/css/**/*.scss', ['styles']);
        gulp.watch('resources/assets/javascript/**/*.*', ['scripts']);

        gulpCallback();
    });
});

// Clean media folder occasionally
gulp.task('clean', function() {
    var del = require('del');
    del([
        'public/media/{local,temporary}/{full,large,small,frames}/*',
        '!public/media/**/**/**/audio.png'
    ]);
});

// Scripts Task. Concat and minify.
gulp.task('scripts', function() {
    var uglify = require('gulp-uglify');
    var concat = require('gulp-concat');
    var rename = require('gulp-rename');

    // Move angular module definition
    gulp.src('resources/assets/javascript/angular/apps/app.js')
        .pipe(gulp.dest('public/js'));

    // Move angular stuff
    gulp.src(['resources/assets/javascript/angular/**/*.js', '!resources/assets/javascript/angular/apps/app.js'])
        .pipe(concat('spacexstatsApp.js')).on('error', handleError)
        //.pipe(uglify()).on('error', handleError)
        .pipe(gulp.dest('public/js')).on('error', handleError)
        .pipe(browserSync.stream());

    // Move templates
    gulp.src('resources/assets/javascript/angular/**/*.html')
        .pipe(rename({ dirname: ''})).on('error', handleError)
        .pipe(gulp.dest('public/js/templates'));

    // Move library
    gulp.src('resources/assets/javascript/lib/**/*.js').on('error', handleError)
        .pipe(gulp.dest('public/js'));
});

// Styles task. Compile all the styles together, autoprefix them, and convert them from SASS to CSS
gulp.task('styles', function() {
    var autoprefixer = require('gulp-autoprefixer');
    var sass = require('gulp-sass');

    gulp.src('resources/assets/css/styles.scss')
        .pipe(sass()).on('error', handleError)
        .pipe(autoprefixer())
        .pipe(gulp.dest('public/css'))
        .pipe(browserSync.stream());

});

// Fonts Task.
gulp.task('fonts', function() {
   gulp.src('resources/assets/fonts/*')
       .pipe(gulp.dest('public/fonts'));
});

// Watch task. Watch for changes automatically and recompile the SASS.
gulp.task('watch', function() {
    gulp.watch('resources/assets/css/**/*.scss', ['styles']);
    gulp.watch('resources/assets/javascript/**/*.*', ['scripts']);
});

gulp.task('default', ['styles', 'watch', 'browsersync']);