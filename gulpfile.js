/**
 * The Gulp file.
 *
 * @package Schlicht
 */

const gulp         = require( 'gulp' );
const sass         = require( 'gulp-sass' );
const autoprefixer = require( 'gulp-autoprefixer' );
const sourcemaps   = require( 'gulp-sourcemaps' );
const rename       = require( 'gulp-rename' );
const flipper      = require( 'gulp-css-flipper' );
const prettier     = require( 'gulp-prettier' );
const csso         = require( 'gulp-csso' );

function sassTask() {
	return (
		gulp
			.src( 'css/scss/*.scss' )
			.pipe( sourcemaps.init() )
			.pipe( sass( {indentWidth: 1, outputStyle: 'expanded', indentType: 'tab'} ).on( 'error', sass.logError ) )
			.pipe( autoprefixer() )
			.pipe( prettier( { tabWidth: 4, useTabs: true,  } ) )
			.pipe( sourcemaps.write( '.' ) )
			.pipe( gulp.dest( 'css' ) )
	);
}

function rtlTask() {
	return (
		gulp
			.src( ['css/*.css', '!css/*-rtl.css', '!css/*.min.css'] )
			.pipe( flipper() )
			.pipe(
				rename(
					{suffix: "-rtl"}
				)
			)
			.pipe( gulp.dest( 'css/' ) )
	);
}

function sassProduction() {
	return (
		gulp
			.src( 'css/scss/*.scss' )
			.pipe( sass( {indentWidth: 1, outputStyle: 'expanded', indentType: 'tab'} ).on( 'error', sass.logError ) )
			.pipe( autoprefixer() )
			.pipe( prettier( { tabWidth: 4, useTabs: true,  } ) )
			.pipe( gulp.dest( 'css' ) )
	);
}

function minifyCSS() {
	return (
		gulp
			.src( ['css/*.css', '!css/*.min.css', '!css/editor-*.css'] )
			.pipe( csso() )
			.pipe(
				rename(
					{suffix: ".min"}
				)
			)
			.pipe( gulp.dest( 'css' ) )
	);
}

function watchTask() {
	return gulp.watch(
		'css/**/*.scss',
		gulp.series(
			sassTask,
			rtlTask,
			minifyCSS
		)
	)
}

gulp.task(
	'default',
	gulp.series(
		sassTask,
		rtlTask,
		minifyCSS,
		watchTask
	)
);

gulp.task(
	'production',
	gulp.series(
		sassProduction,
		rtlTask,
		minifyCSS
	)
);
