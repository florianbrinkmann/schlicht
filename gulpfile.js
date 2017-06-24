const gulp = require('gulp');
const rename = require('gulp-rename');
const flipper = require('gulp-css-flipper');

gulp.task('css-rtl', function () {
	return gulp.src(['css/*.css', '!css/*-rtl.css'])
		.pipe(flipper())
		.pipe(rename(
			{suffix: "-rtl"}
		))
		.pipe(gulp.dest('css/'));
});

gulp.task('default', ['css-rtl'], function () {
	gulp.watch('css/*.css', ['css-rtl']);
});

gulp.task('production', ['css-rtl']);
