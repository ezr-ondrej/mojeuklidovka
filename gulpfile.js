var gulp = require('gulp');

/* npm install --save-dev gulp-concat, gulp-rename, gulp-uglify */
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var minifyCSS = require('gulp-minify-css');

var paths = {
    webCSS: [
        'public/assets/web/**/css/*.css',
        '!public/assets/web/**/css/*.min.css'
    ],
    webJS: [
        'public/assets/web/**/js/*.js',
        '!public/assets/web/**/js/*.min.js',
        '!public/assets/web/**/js/vendor/*.js'
    ]
};

gulp.task('web-minifyCSS', function(done) {
    return gulp.src(paths.webCSS)
        .pipe(rename({suffix: '.min'}))
        .pipe(minifyCSS({keepBreaks: false}))
        .pipe(gulp.dest('public/assets/web/'))
});

gulp.task('web-uglifyJS', function (done) {
    return gulp.src(paths.webJS)
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('public/assets/web/'))
});

gulp.task('web-watch', function () {
    gulp.watch(paths.webCSS, ['web-minifyCSS']);
    gulp.watch(paths.webJS, ['web-uglifyJS']);
});

gulp.task('default', ['web-watch']);
