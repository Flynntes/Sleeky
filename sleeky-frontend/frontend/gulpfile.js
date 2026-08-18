var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));

// Shared source glob: the watch task must cover the same files the sass
// task compiles (was "sass/*.scss", which never matched anything).
var sassSrc = './assets/sass/*.scss';

gulp.task('sass', () => {
    return gulp.src(sassSrc)
        .pipe(sass())
        .pipe(gulp.dest("dist/"))
});

gulp.task('start', gulp.series('sass', function () {
    gulp.watch(sassSrc, gulp.series('sass'));
}));

gulp.task('default', gulp.series('start'));