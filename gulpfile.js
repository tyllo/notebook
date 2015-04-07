'use strict';

var gulp        = require('gulp');
var scss        = require('gulp-sass');
var mincss      = require('gulp-csso');


gulp.task('components/datetimepicker', function() {
	var src = 'bower_components/datetimepicker';
	gulp.src(src + '/jquery.datetimepicker.js')
		.pipe(gulp.dest('dest/js/'))
		.on('error', console.log);
	gulp.src(src + '/jquery.datetimepicker.css')
		.pipe(gulp.dest('dest/css/'))
		.on('error', console.log);
});
gulp.task('components/jquery', function() {
	var src = 'bower_components/jquery';
	gulp.src(src + '/dist/jquery.min.js')
		.pipe(gulp.dest('dest/js/'))
		.on('error', console.log);
});
gulp.task('components/modernizr', function() {
	var src = 'bower_components/modernizr';
	gulp.src(src + '/modernizr.js')
		.pipe(gulp.dest('dest/js/'))
		.on('error', console.log);
});
gulp.task('components/foundation', function() {
	var src = 'bower_components/foundation';
	gulp.src(src + '/js/*min.js')
		.pipe(gulp.dest('dest/js/'))
		.on('error', console.log);
	gulp.src(src + '/scss/foundation.scss')
		.pipe(scss())
		.pipe(mincss())
		.pipe(gulp.dest('dest/css/'))
		.on('error', console.log);
	// копируем все scss в src/scss/
	// поможет для переопределения стилей
	// foundation, [хоть можно в свой app.scc
	// взять нужные куски от foundation]
	gulp.src(src + '/scss/**/*')
		.pipe(gulp.dest('src/scss/'))
		.on('error', console.log);
});
gulp.task('components/font-awesome', function() {
	var src = 'bower_components/font-awesome';
	gulp.src(src + '/scss/font-awesome.scss')
		.pipe(scss())
		.pipe(mincss())
		.pipe(gulp.dest('dest/css/'))
		.on('error', console.log);
	gulp.src(src + '/fonts/**')
		.pipe(gulp.dest('dest/fonts/'))
		.on('error', console.log);
});
gulp.task('components/cropper', function() {
	var src = 'bower_components/cropper/dist';
	gulp.src(src + '/cropper.min.css')
		.pipe(gulp.dest('dest/css/'))
		.on('error', console.log);
	gulp.src(src + '/cropper.min.js')
		.pipe(gulp.dest('dest/js/'))
		.on('error', console.log);
});

gulp.task('src', function() {
	gulp.src('src/scss/app.scss')
		.pipe(scss())
		.pipe(gulp.dest('dest/css/'))
		.on('error', console.log);
	gulp.src('src/js/app.js')
		.pipe(gulp.dest('dest/js/'))
		.on('error', console.log);
});


// Предварительная сборка проекта
gulp.task('build', function() {
  gulp.run('components/datetimepicker');
  gulp.run('components/jquery');
  gulp.run('components/modernizr');
  //gulp.run('components/foundation');
	gulp.run('components/font-awesome');
	//gulp.run('components/cropper');
	gulp.run('src');
});

// вотчер
gulp.task('watch', function() {
	gulp.watch([
		'src/scss/*.scss',
		'src/js/*.js'
		], function() {
            gulp.run('src');
        });
});
