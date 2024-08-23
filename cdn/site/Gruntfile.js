module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			style: {
				src: [
					'css/bootstrap.min.css',
					'css/font-awesome.min.css',
					'css/angular-growl.min.css',
					'css/style.css'
					],
				dest: 'build/style.css'
			},
			core: {
				src: [
					'js/angular/angular.min.js',
					'js/angular-sanitize/angular-sanitize.min.js', 
					'js/bootstrap/ui-bootstrap-tpls-2.5.0.min.js',
					'js/angular-animate/angular-animate.js',
					'js/growl/angular-growl.min.js',
					'js/angular-recaptcha/angular-recaptcha.min.js'
					],
				dest: 'build/core.js',
			},
			app: {
				src: [
					'app/app.js',
					'app/filters/filters.js',
					'app/directives/preloader.js',
					'app/directives/comments.js',
					'app/services/AppService.js',
					'app/services/CommentService.js', 
					'app/controllers/*'
					],
				dest: 'build/app.js',
			},
		},
		cssmin: {
			target: {
				files: [{
					src: [
						'build/style.css'
						],
					dest: 'build/style.min.css',
					ext: '.min.css'
				}]
			}
		},
		uglify: {
			options: {
				mangle: false
			},
			build: {
				files: {
					'build/core.min.js'	  : 'build/core.js',
					'build/app.min.js'	  : 'build/app.js'
				}
			}
		}
	});

	// Load the plugin that provides the "uglify" task.
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// Default task(s).
	grunt.registerTask('default', ['concat', 'cssmin', 'uglify']);

};