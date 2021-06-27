var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));

gulp.task('sass', () => {
    return gulp.src("./assets/sass/*.scss")
        .pipe(sass())
        .pipe(gulp.dest("dist/"))
});

gulp.task('start', gulp.series('sass', function () {
    gulp.watch("sass/*.scss", gulp.series('sass'));
}));

gulp.task('default', gulp.series('start'));