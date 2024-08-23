/**
 * Preloader
 */
app.directive('preloader', ['$animate', '$timeout', '$q', function($animate, $timeout, $q){
	
	var directive = {
		restrict: 'EAC',
		template: 
		  '<div class="preloader-progress">' +
			  '<div class="preloader-progress-bar" ' +
				   'ng-style="{width: loadCounter + \'%\'}"></div>' +
		  '</div>'
		,
		link: link
	};
	return directive;

	///////

	function link(scope, el) {

	  scope.loadCounter = 0;

	  var counter  = 0,
		  timeout;

	  // disables scrollbar
	  angular.element('body').css('overflow', 'hidden');
	  // ensure class is present for styling
	  el.addClass('preloader');

	  //appReady().then(endCounter);
	  endCounter();
	  timeout = $timeout(startCounter);

	  ///////

	  function startCounter() {

		var remaining = 100 - counter;
		counter = counter + (0.015 * Math.pow(1 - Math.sqrt(remaining), 2));

		scope.loadCounter = parseInt(counter, 10);

		timeout = $timeout(startCounter, 20);
	  }

	  function endCounter() {

		$timeout.cancel(timeout);

		scope.loadCounter = 100;

		$timeout(function(){
		  // animate preloader hiding
		  $animate.addClass(el, 'preloader-hidden');
		  // retore scrollbar
		  angular.element('body').css('overflow', '');
		}, 300);
	  }

	  function appReady() {
		var deferred = $q.defer();
		var viewsLoaded = 0;
		// if this doesn't sync with the real app ready
		// a custom event must be used instead
		var off = scope.$on('$viewContentLoaded', function () {
		  viewsLoaded ++;
		  // we know there are at least two views to be loaded 
		  // before the app is ready (1-index.html 2-app*.html)
		  if ( viewsLoaded === 1) {
			// with resolve this fires only once
			$timeout(function(){
			  deferred.resolve();
			}, 1000);

			off();
		  }

		});

		return deferred.promise;
	  }

	} //link
}]);

app.directive('sectionloader', ['$animate', '$timeout', '$q', function($animate, $timeout, $q){
	
	var directive = {
		restrict: 'EAC',
		scope: {
			'loading' : '='
		},
		template: 
		  '<div class="section-loader" ng-show="loading">' +
			  '<div class="section-loader-animation"><em class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></em></div>' +
		  '</div>'
		,
		link: link
	};
	return directive;

	function link(scope, el) {
	}
}]);


app.directive('routerloader', ['$animate', function($animate){
	
	var directive = {
		restrict: 'EAC',
		scope: {
			'loading' : '='
		},
		template: 
		  '<div class="router-loader" ng-show="loading">'+
			'<div class="progress progress-striped active">'+
				'<div class="progress-bar progress-bar-color" id="bar" role="progressbar" style="width: 1000%;"></div>'+
			'</div>',

		link: link
	};
	return directive;

	function link(scope, el) {
	}
}]);
