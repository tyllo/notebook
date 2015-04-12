'use strict';

var gulp       = require('gulp'),
    sass       = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    csso       = require('gulp-csso'),
		svgo       = require('gulp-svgo'),
    eol        = require('gulp-eol'),
    rename     = require('gulp-rename'),
    uglify     = require('gulp-uglify'),
//  watch      = require('gulp-watch'),
    
		paths      = {
		css: {
			src: [
				'./bower_components/foundation/scss',
				'./bower_components/font-awesome/scss',
				'./src/scss'
			],
			files: [
				'./src/scss/*.scss',
				'./bower_components/font-awesome/scss/font-awesome.scss',
				'./bower_components/datetimepicker/jquery.datetimepicker.css',
			],
			dest: './dest/css',
			map: './',
		},
		js:  {
			files: [
				'./src/js/app.js',
				'./bower_components/modernizr/modernizr.js',
				'./bower_components/foundation/js/foundation.js',
				'./bower_components/jquery/dist/jquery.js',
				'./bower_components/datetimepicker/jquery.datetimepicker.js',
				'./bower_components/jquery-maskedinput/dist/jquery.maskedinput.js'
			],
			dest: './dest/js'
		},
		svg: {
			files: 'src/images/avatar-svg/**',
			dest: 'dest/images/avatar-svg'
		}
	};

gulp.task('css', function() {
	gulp
		.src(paths.css.files)
		.pipe(sourcemaps.init({loadMaps: true}))
			.pipe(sass({
					// style: 'compressed',
					// sourceComments: 'map',
					includePaths: paths.css.src
				}))
			.pipe(rename({suffix: ".min"}))
			.pipe(csso())
			.pipe(eol('\n'))
		.pipe(sourcemaps.write(paths.css.map))
		.pipe(gulp.dest(paths.css.dest))
		.on('error', console.log);
});
gulp.task('js', function() {
	gulp
		.src(paths.js.files)
		.pipe(eol('\n'))
		.pipe(rename({suffix: ".min"}))
		.pipe(uglify())	
		.pipe(gulp.dest(paths.js.dest))
		.on('error', console.log);
});
gulp.task('font', function() {
	var src = './bower_components/';
	gulp
		.src([
			src + 'font-awesome/fonts/**'
		])
		.pipe(gulp.dest('dest/fonts/'))
		.on('error', console.log);
});
gulp.task('files', function() {
	gulp
		.src([
			'src/index.php',
			'src/.htaccess'
		])
		.pipe(gulp.dest('./dest/'))
		.on('error', console.log);
});
gulp.task('svg', function() {
	gulp
		.src(paths.svg.files)
		.pipe(gulp.dest(paths.svg.dest))
		.pipe(svgo())
		.on('error', console.log);
});

// Сборка проекта
gulp.task('build', function() {
  gulp.run('css');
  gulp.run('js');
  gulp.run('font');
	gulp.run('files');
	gulp.run('svg');
});

// Вотчер
gulp.task('watch', function() {
	// следим за изменением только
	// первой строчки paths.css.files
	gulp.watch(paths.css.files[0],
		function() {
			gulp.run('css');
    });
	// следим за изменением только
	// первой строчки paths.js.files
	gulp.watch(paths.js.files[0],
		function() {
			gulp.run('js');
	});
	gulp.watch('src/*',
		function() {
			gulp.run('files');
	});
	gulp.watch(paths.svg.files,
		function() {
			gulp.run('files');
	});
});

// дефолтный таск
gulp.task('default', function(){
	gulp.run('watch');
});







