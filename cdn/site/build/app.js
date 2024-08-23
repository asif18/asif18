var app;

/**
 * Create the asif18 module
 */
app = angular.module('asif18', ['ui.bootstrap', 'ngAnimate', 'angular-growl', 'ngSanitize', 'vcRecaptcha']);

angular.element( document.getElementsByTagName('pre')).addClass('prettyprint');

app.config(['growlProvider', function(growlProvider) {
	
	//Growl
	growlProvider.onlyUniqueMessages(true);
	
}]);
app.filter('capitalize', function() {
	return function(input, all) {
	  var reg = (all) ? /([^\W_]+[^\s-]*) */g : /([^\W_]+[^\s-]*)/;
	  return (!!input) ? input.replace(reg, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();}) : '';
	}
});
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


/**
 * Comments Directive
 */

var CommentsController =  function($scope, CommentService) {
	
	$scope.model = { assetsUrl: APPCONFIG.assetsUrl };
	var self = this;
	
	this.$onInit = function () {
		
		$scope.model.articleId = self.articleId;
		
	};
	
	
};

var CommentsFormController =  function($scope, $timeout, $window, $uibModal, growl, CommentService, vcRecaptchaService) {
	
	$scope.model = { assetsUrl: APPCONFIG.assetsUrl, isLoading: false, gCaptchaSiteKey: APPCONFIG.gCaptchaSiteKey, response: null, widgetId: null, formData: { name: '', email: '', comment: ''} };
	
	var self = this;
	
	this.$onInit = function () {
		
		$scope.model.articleId 	 = self.articleId;
		$scope.model.commentType = self.commentType;
		$scope.model.commentId 	 = (self.commentId) ? self.commentId : null;
	};
	
	/**
	 * Set Response
	 *
	 * @param response
	 * @type Object/String
	 */
	$scope.setResponse = function (response) {
		$scope.model.response = response;
	};
	
	/**
	 * Set Widget ID
	 *
	 * @param widgetId
	 * @type String
	 */
	$scope.setWidgetId = function (widgetId) {
		$scope.model.widgetId = widgetId;
	};
	
	/**
	 * Captcha Expiration
	 *
	 * @param null
	 */
	$scope.cbExpiration = function() {
		vcRecaptchaService.reload($scope.model.widgetId);
		$scope.model.response = null;
	 };
	
	/**
	 * Auto Expand
	 *
	 * @param e
	 * @type Object/String
	 */
	$scope.autoExpand = function(e) {
        var element 		 = typeof e === 'object' ? e.target : document.getElementById(e);
    	var scrollHeight	 = element.scrollHeight;
        element.style.height =  scrollHeight + "px";    
    };
	
	$scope.autoExpand('comment');
	
	/**
	 * Save Comment
	 *
	 * @param null
	 */
	$scope.saveComment = function() {
		
		// Validation
		if($scope.model.articleId == '') {
			
			growl.error('Invalid commenting on article', { ttl: 3000 });
			return false;
		}
		
		if($scope.model.formData.name == '') {
			
			growl.error('Enter name', { ttl: 5000 });
			return false;
		}
		
		if($scope.model.formData.email == '') {
			
			growl.error('Enter email', { ttl: 5000 });
			return false;
		}
		
		if($scope.model.formData.comment == '') {
			
			growl.error('Enter comments', { ttl: 5000 });
			return false;
		}
		
		if($scope.model.response === null ) {
			growl.error('Please check the captcha', { ttl: 3000 });
			return false;
		}
		
		var postData = { 
						articleId	: $scope.model.articleId,
						commentId	: $scope.model.commentId,
						name		: $scope.model.formData.name,
						email		: $scope.model.formData.email,
						comments	: $scope.model.formData.comment,
						captcha		: $scope.model.response 
					   };
		
		$scope.model.isLoading = true;
		CommentService.saveComment(postData).then(function(response) {
			
			// Reload Captcha
			$scope.cbExpiration();
			
			$scope.model.isLoading = false;
			
			if(response.data.status == true) {
				
				$uibModal.open({
					templateUrl : 'showMessage.html',
					animation	: true,
					size		: 'md',
					static		: true,
					resolve		: {
						modalData: function() {
							return { msg: response.data.msg };
						}
					},
					controller	: ['$scope', '$window', 'modalData', function($scope, $window, modalData) {
					
						$scope.msg = modalData.msg;
						
						/**
						 * Okay
						 *
						 * @param null
						 */
						$scope.okay = function() {
							
							$window.location.reload();
						};
					}]
				});
				
			}
			
		});
	};
};

var CommentsShowerController =  ['$scope', '$timeout', 'CommentService', function($scope, $timeout, CommentService) {
	
	$scope.model = { assetsUrl: APPCONFIG.assetsUrl, isLoading: false };
	var self = this;
	
	/**
	 * Init
	 *
	 * @param null
	 */
	this.$onInit = function () {
		
		$scope.model.articleId = self.articleId;
		
		$scope.getComments();
	};
	
	/**
	 * Get Comments
	 *
	 * @param null
	 */
	$scope.getComments = function() {
		
		var postData = { articleId: $scope.model.articleId };
		
		$scope.model.isLoading = true;
		CommentService.getComments(postData).then(function(response) {
			$scope.model.isLoading    = false;
			$scope.model.commentsData = response.data;
			
			$timeout(function() {
				angular.element( document.getElementsByTagName('pre')).addClass('prettyprint');
			}, 500);
			
		});
	};
	
}];

app.directive('comments', function() {
	
	return {
		restrict: 'EA',
		controller: CommentsController,
		scope: {
			articleId: '='
		},
		bindToController: true,
		templateUrl: APPCONFIG.assetsUrl+'site/app/views/comments.html'
	}
});

app.directive('commentForm', function() {
	
	return {
		restrict: 'E',
		controller: CommentsFormController,
		scope: {
			articleId	  : '=',
			commentType	  : '=',
			commentId	  : '='
		},
		bindToController: true,
		templateUrl: APPCONFIG.assetsUrl+'site/app/views/comments-form.html'
	}
});

app.directive('commentShower', function() {
	
	return {
		restrict: 'EA',
		controller: CommentsShowerController,
		scope: {
			articleId: '=',
			commentId: '='
		},
		bindToController: true,
		templateUrl: APPCONFIG.assetsUrl+'site/app/views/comments-shower.html'
	}
});
/**
 * App Web Service
 * Name: AppService
 */
app.service('AppService', ['$timeout', '$rootScope', '$http', 'growl', function ($timeout, $rootScope, $http, growl) {
	
	/**
	 * var declaration
	 */
	var AppServiceOp = {};
	
	/**
	 * Check JSON
	 *
	 * Name: isJson
	 * @param: data
	 * @type: jsonArray/jsonObject
	 */
	AppServiceOp.isJson = function(response) {
		var contentType = typeof response;
		contentType.toLowerCase();
		
		if(contentType == 'json' || contentType == 'object'){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Check exception
	 *
	 * Name: checkException
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.checkNetworkException = function(response) {
		
		// If the response is not empty
		if(!response) {
			AppServiceOp.systemError();
			return false;
		}
		
		// If the response is not JSON
		if(!AppServiceOp.isJson(response.data)) {
			AppServiceOp.systemError();
			return false;
		}
		
		// If the response has any exception
		if(response.data.exception !== null) {
			if(response.data.exception.status) {
				AppServiceOp.systemError(response.data.exception.msg);
				return false;
			}
		}
		return true;
	};

	/**
	 * System error
	 *
	 * @param: msg
	 * @type: String
	 */
	AppServiceOp.systemError = function(msg) {
		
		if(msg) {
			growl.error(msg, { ttl: 3000 });
		} else {
			growl.error('Something went wrong! Server is not giving expected response. Try again later', { ttl: 3000 });
		}
	};
	
	/**
	 * Return all the methods
	 */
	return AppServiceOp;
	
}]);
/**
 * Comment Web Service
 * Name: CommentService
 */
app.service('CommentService', ['$http', 'AppService', function ($http, AppService) {
	
	/**
	 * var declaration
	 */
	var AppServiceOp = {};
	
	/**
	 * Get Comments
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.getComments = function(data) {
		
		return $http.post(APPCONFIG.WSURLS.getComments, data).then(function(response){
						if(AppService.checkNetworkException(response)) {
							return response.data;
						} else {
							return false;
						}
						
					}, function(response){
						AppService.checkNetworkException(response);
					});
	};
	
	/**
	 * Save Comment
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.saveComment = function(data) {
		return $http.post(APPCONFIG.WSURLS.saveComment, data).then(function(response){
						if(AppService.checkNetworkException(response)) {
							return response.data;
						} else {
							return false;
						}
						
					}, function(response){
						AppService.checkNetworkException(response);
					});
	};
	
	/**
	 * Return all the methods
	 */
	return AppServiceOp;
	
}]);
/**
 * Header Controller
 */

app.controller('HeaderController', ['$scope', function($scope){
	
	/**
	 * Init
	 *
	 * @param null
	 */
	function init() {
	}
	
	$scope.model = { collapseMainMenu: true };
		
	// init
	init();
	
}]);
