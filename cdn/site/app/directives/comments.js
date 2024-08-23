
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