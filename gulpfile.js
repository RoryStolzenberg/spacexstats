var gulp = require('gulp');

gulp.task('browsersync', function() {
    browserSync = require('browser-sync');

    browserSync.init({
        proxy: "spacexstats.dev"
    });
});

// Scripts Task
gulp.task('scripts', function() {
    var uglify = require('gulp-uglify');

    gulp.src('public/src/js/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('public/dest/js'));
});

gulp.task('styles', function() {
    var autoprefixer = require('gulp-autoprefixer');
    var sass = require('gulp-sass');

    gulp.src('public/src/css/styles.scss')
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest('public/dest/css'));
});

gulp.task('images', function() {
    var imagemin = require('gulp-imagemin');

    gulp.src('public/src/images/*')
        .pipe(imagemin())
        .pipe(gulp.dest('public/dest/images'));
});

// Watch task
gulp.task('watch', function() {
    gulp.watch('public/src/css/styles.scss', ['styles']);
});

gulp.task('default', ['styles', 'watch']);