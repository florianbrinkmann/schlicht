const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const rename = require('gulp-rename');
const flipper = require('gulp-css-flipper');

function sassTask() {
	return (
		gulp
			.src('css/scss/*.scss')
			.pipe(sourcemaps.init())
			.pipe(sass({indentWidth: 1, outputStyle: 'expanded', indentType: 'tab'}).on('error', sass.logError))
			.pipe(autoprefixer())
			.pipe(sourcemaps.write('.'))
			.pipe(gulp.dest('css'))
	);
}

function rtlTask() {
	return (
		gulp
			.src(['css/*.css', '!css/*-rtl.css'])
			.pipe(flipper())
			.pipe(rename(
				{suffix: "-rtl"}
			))
			.pipe(gulp.dest('css/'))
	);
}

function sassProduction() {
	return (
		gulp
			.src('css/scss/*.scss')
			.pipe(sass({indentWidth: 1, outputStyle: 'expanded', indentType: 'tab'}).on('error', sass.logError))
			.pipe(autoprefixer())
			.pipe(gulp.dest('css'))
	);
}

function watchTask() {
	return gulp.watch('css/scss/*.scss', gulp.series(
		sassTask,
		rtlTask
	))
}

gulp.task('default', gulp.series(
		sassTask,
		rtlTask,
		watchTask,
	),
);

gulp.task('production', gulp.series(
		sassProduction,
		rtlTask
	),
);
