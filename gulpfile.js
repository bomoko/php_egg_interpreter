var gulp = require('gulp');
var phpspec = require('gulp-phpspec');
var run = require('gulp-run');
var notify = require('gulp-notify');

gulp.task('test',function(){
  //notify("Running");
  gulp.src('spec/**/*.php')
    .pipe(phpspec('', {notify: true}))
    .on('error', notify.onError({
      title: 'Crap :(',
      message: 'Something failed'
    }))
    .pipe(notify({
      title: 'All tests successful',
      description: 'all green'
    }));

});


gulp.task('watch',function(){
  gulp.watch(['spec/**/*.php','src/**/*.php'],['test']);
});

gulp.task('default',['test','watch']);
