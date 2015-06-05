var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-ruby-sass'),
    imagemin = require('gulp-imagemin'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync');

gulp.task('browsersync', function() {
    browserSync.init({
        proxy: "spacexstats.dev"
    });
});

// Scripts Task
gulp.task('scripts', function() {
    return gulp.src('public/src/js/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('public/dest/js'));
});

gulp.task('styles', function() {
    return sass('public/src/css/styles.scss', { style: 'compressed' })
        .pipe(autoprefixer())
        .pipe(gulp.dest('public/dest/css'));
});

gulp.task('images', function() {
    gulp.src('public/src/images/*')
        .pipe(imagemin())
        .pipe(gulp.dest('public/dest/images'));
});

// Watch task
gulp.task('watch', function() {
    gulp.watch('public/src/css/styles.scss', ['styles']);
});

gulp.task('default', ['styles', 'watch']);