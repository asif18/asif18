var app;

/**
 * Create the admin  module
 */
app = angular.module('admin', ['ui.bootstrap', 'ui.router', 'angular-growl', 'ngAnimate', 'ckeditor']);

angular.element( document.getElementsByTagName('pre')).addClass('prettyprint');

/**
 * Config
 */
app.config(['$sceDelegateProvider','$stateProvider', '$urlRouterProvider', '$locationProvider', 'growlProvider', function($sceDelegateProvider, $stateProvider, $urlRouterProvider, $locationProvider, growlProvider) {
	
	$sceDelegateProvider.resourceUrlWhitelist(['self']);
	
	//Remove ! symbol from URL
	$locationProvider.html5Mode(false);
	$locationProvider.hashPrefix('');
	
	// UI Router
	$urlRouterProvider.otherwise('/login');
	
	$stateProvider
	
		.state('app', {
			abstract: true,
			url: '',
			views : {
				'app': {
					templateUrl : APPCONFIG.baseUrl+'cdn/admin/app/views/app-abs.html'
				}
			}
			
		})
		.state('login', {
			abstract: true,
			url: '',
			views : {
				'login': {
					templateUrl : APPCONFIG.baseUrl+'cdn/admin/app/views/login-abs.html'
				}
			}
			
		})
		.state('login.loginpage', {
			url: '/login',
			views: {
				'loginsection': {
					templateUrl : APPCONFIG.baseUrl+'cdn/admin/app/views/login.html',
					controller	: 'LoginController',
				}
			},
			data: {
				requireLogin : false,
				pageTitle	 : 'Login'
			}
		})
		.state('app.dashboard', {
			url: '/dashboard',
			views: {
				'main': {
					templateUrl : APPCONFIG.baseUrl+'cdn/admin/app/views/dashboard.html',
					controller	: 'DashboardController',
				}
			},
			data: {
				requireLogin : true,
				pageTitle	 : 'Dashboard'
			}
		})
		.state('app.category', {
			url: '/category/:categoryId',
			views: {
				'main': {
					templateUrl : APPCONFIG.baseUrl+'cdn/admin/app/views/category.html',
					controller	: 'CategoryController'
				}
			},
			params: { 
				categoryId: null 
			},
			data: {
				requireLogin : true,
				pageTitle	 : 'Category'
			}
		})
		.state('app.listCategories', {
			url: '/category-list',
			views: {
				'main': {
					templateUrl : APPCONFIG.baseUrl+'cdn/admin/app/views/category-list.html',
					controller	: 'CategoryListController',
				}
			},
			data: {
				requireLogin : true,
				pageTitle	 : 'Category List'
			}
		})
		.state('app.article', {
			url: '/article/:articleId',
			views: {
				'main': {
					templateUrl : APPCONFIG.baseUrl+'cdn/admin/app/views/article.html',
					controller	: 'ArticleController',
				}
			},
			params: { 
				articleId: null 
			},
			data: {
				requireLogin : true,
				pageTitle	 : 'Article'
			}
		})
		.state('app.listArticles', {
			url: '/article-list',
			views: {
				'main': {
					templateUrl : APPCONFIG.baseUrl+'cdn/admin/app/views/article-list.html',
					controller	: 'ArticleListController',
				}
			},
			data: {
				requireLogin : true,
				pageTitle	 : 'Article List'
			}
		});
	
	//Growl
	growlProvider.onlyUniqueMessages(true);
	
}]);

app.run(['$rootScope', '$state', '$transitions', '$interval', 'LoginService', 'growl', function($rootScope, $state, $transitions, $interval, LoginService, growl) {
	
	// Check frequently if the session is available
	
	$interval(function() {
		LoginService.sessionCheck().then(function(response){
			if(response.data.status === false) {
				if($rootScope.currentState != 'login.loginpage') {
					growl.error("Session expired. Redirecting..", {ttl: 5000});
				}
				$state.go('login.loginpage');
			} else {
				$rootScope.vm.user = response.data.user;
			}
		});
	}, 10000);
	
	
	var criteria = {
		to: function(state) {
			return state.data != null;
		}
	};
	
	$transitions.onStart(criteria, function(trans){
		
		var state 				= trans.to();
		$rootScope.currentState = state.name;
		
		if(state.data.requireLogin === true) {
			
			// Prevent user if not logged in
			LoginService.sessionCheck().then(function(response){
				if(response.data.status === false) {
					growl.error("Session expired. Redirecting..", {ttl: 5000});
					$state.go('login.loginpage');
				} else {
					$rootScope.vm.user = response.data.user;
				}
			});			
		}
		
		// Set page title
		$rootScope.vm.pageTitle = APPCONFIG.appName + ' - ' +state.data.pageTitle;
	});
	
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
			  '<div class="section-loader-animation"></div>' +
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
 * Login Web Service
 * Name: LoginService
 */
app.service('LoginService', ['$http', 'AppService', function ($http, AppService) {
	
	/**
	 * var declaration
	 */
	var AppServiceOp = {};
	
	/**
	 * Login WS
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.login = function(data) {
		return $http.post(APPCONFIG.WSURLS.login, data).then(function(response){
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
	 * Check the session
	 *
	 * @param: null
	 */
	AppServiceOp.sessionCheck = function() {
		return $http.get(APPCONFIG.WSURLS.sessionCheck).then(function(response){
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
 * Article Web Service
 * Name: ArticleService
 */
app.service('ArticleService', ['$http', 'AppService', function ($http, AppService) {
	
	/**
	 * var declaration
	 */
	var AppServiceOp = {};
	
	/**
	 * Get Articlea
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.getArticles = function(data) {
		return $http.post(APPCONFIG.WSURLS.getArticles, data).then(function(response){
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
	 * Save Article
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.saveArticle = function(data) {
		return $http.post(APPCONFIG.WSURLS.saveArticle, data).then(function(response){
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
	 * Get Article by ID
	 *
	 * @param: data
	 * @type jsonArray
	 */
	AppServiceOp.getArticleById = function(data) {
		return $http.post(APPCONFIG.WSURLS.getArticleById, data).then(function(response){
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
	 * Update Article Status
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.updateArticleStatus = function(data) {
		return $http.post(APPCONFIG.WSURLS.updateArticleStatus, data).then(function(response){
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
 * Login Web Service
 * Name: CategoryService
 */
app.service('CategoryService', ['$http', 'AppService', function ($http, AppService) {
	
	/**
	 * var declaration
	 */
	var AppServiceOp = {};
	
	/**
	 * Get Category
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.getCategory = function(data) {
		return $http.post(APPCONFIG.WSURLS.getCategory, data).then(function(response){
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
	 * Save Category
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.saveCategory = function(data) {
		return $http.post(APPCONFIG.WSURLS.saveCategory, data).then(function(response){
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
	 * Get Categories
	 *
	 * @param: null
	 */
	AppServiceOp.getCategories = function() {
		return $http.get(APPCONFIG.WSURLS.getCategories).then(function(response){
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
	 * Get Category by ID
	 *
	 * @param: data
	 * @type jsonArray
	 */
	AppServiceOp.getCategoryById = function(data) {
		return $http.post(APPCONFIG.WSURLS.getCategoryById, data).then(function(response){
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
 * App Controller
 */

app.controller('AppController', ['$rootScope', '$scope', function($rootScope, $scope){
	
	$scope.model  = { appName: APPCONFIG.appName, year: ((new Date()).getFullYear()) };
	$rootScope.vm = { pageLoader: false };
	
	// Menu items
	$scope.model.menuItems = [
								{
									name	: 'app.dashboard',
									label 	: 'Dashboard',
									icon	: 'fa fa-dashboard',
									submenu : []
								},
								{
									name	: 'app.category',
									label 	: 'Add Category',
									icon	: 'fa fa-plus',
									submenu : []
								},
								{
									name	: 'app.listCategories',
									label 	: 'List Categories',
									icon	: 'fa fa-list',
									submenu : []
								},
								{
									name	: 'app.article',
									label 	: 'Add Article',
									icon	: 'fa fa-plus',
									submenu : []
								},
								{
									name	: 'app.listArticles',
									label 	: 'List Articles',
									icon	: 'fa fa-list',
									submenu : []
								}
							 ];
}]);
/**
 * Article Controller
 */

app.controller('ArticleController', ['$rootScope', '$scope', '$state', '$stateParams', 'growl', 'ArticleService', 'CategoryService', function($rootScope, $scope, $state, $stateParams, growl, ArticleService, CategoryService){
	
	/**
	 * Init
	 *
	 * @param null
	 */
	function init() {
		$scope.model.sectionLoader = false;
		
		// Edit Mode
		if($stateParams.articleId > 0) {
			
			$scope.model.sectionLoader 		= false;
			$scope.model.editMode 			= true;
			$scope.model.formData.articleId	= $stateParams.articleId;
			ArticleService.getArticleById({ articleId: $scope.model.formData.articleId }).then(function(response){
				
				$scope.model.sectionLoader = false;
				if(response.data.status === true) {
					$scope.model.categories = response.data.categories;
					$scope.model.formData 	= response.data.articleData;
					
				} else {
					growl.error("Error while retriving the category", {ttl: 5000});
				}
				
			});
			
		} else {
			
			// Add Mode
			$scope.model.editMode = false;
			
			$scope.model.sectionLoader = true;
			CategoryService.getCategories().then(function(response){
				
				$scope.model.sectionLoader = false;
				if(response.data.status === true) {
					$scope.model.categories = response.data.categories;
				} else {
					growl.error("Error while loading the categories", {ttl: 5000});
				}
				
			});	
		}
	}
	
	$scope.model = { editMode: false, sectionLoader: true, categories: null, formData: { articleId: null, topic: '', category: '', breadCrumbs: '', keywords: '', description: '', demoLink: '', downloadFile: '', content: '' } };
	
	// Editor options.
	$scope.model.options = {
		language		: 'en',
		allowedContent	: true,
		entities		: false
	};

	/**
	 * On Editor Ready
	 *
	 * @param null
	 */
	$scope.onEditorReady = function() {
		
		$scope.model.sectionLoader = false;
		
	};
	
	/**
	 * Save
	 *
	 * @param null
	 */
	$scope.save = function() {
		
		// Validation
		if($scope.model.formData.topic == '') {
			
			growl.error('Enter topic',  {ttl: 5000} );
			return false;
		}
		
		if($scope.model.formData.category == '') {
			
			growl.error('Select category',  {ttl: 5000} );
			return false;
		}
		
		if($scope.model.formData.breadCrumbs == '') {
			
			growl.error('Enter breadcrumbs',  {ttl: 5000} );
			return false;
		}
		
		if($scope.model.formData.keywords == '') {
			
			growl.error('Enter keywords',  {ttl: 5000} );
			return false;
		}
		
		if($scope.model.formData.description == '') {
			
			growl.error('Enter description',  {ttl: 5000} );
			return false;
		}
		
		if($scope.model.formData.content == '') {
			
			growl.error('Enter content',  {ttl: 5000} );
			return false;
		}
		
		$scope.model.sectionLoader = true;
		
		var postData = { 
							articleId	: $scope.model.formData.articleId, 
							topic		: $scope.model.formData.topic, 
							category	: $scope.model.formData.category, 
							breadCrumbs	: $scope.model.formData.breadCrumbs, 
							keywords	: $scope.model.formData.keywords, 
							description	: $scope.model.formData.description, 
							demoLink	: $scope.model.formData.demoLink, 
							downloadFile: $scope.model.formData.downloadFile, 
							content		: $scope.model.formData.content,
							postedBy	: $rootScope.vm.user.user_id
						};
		ArticleService.saveArticle(postData).then(function(response){
			
			$scope.model.sectionLoader = false;
			if(response.data.status === true) {
				growl.success(response.data.msg, {ttl: 5000});
				$state.go('app.listArticles');
			} else {
				growl.error("Error while saving the article", {ttl: 5000});
			}
		});
	};
	
	// init
	init();
	
}]);

/**
 * Article List Controller
 */

app.controller('ArticleListController', ['$scope', '$state', '$stateParams', 'ArticleService', 'growl', function($scope, $state, $stateParams, ArticleService, growl){

	/**
	 * Init
	 *
	 * @param null
	 */
	function init() {
		
		$scope.model.sectionLoader = true;
		ArticleService.getArticles($scope.model.filters).then(function(response){
			
			$scope.model.sectionLoader = false;
			if(response.data.status === true) {
				$scope.model.articles = response.data.articles;
			} else {
				growl.error("Error while loading the articles", {ttl: 5000});
			}
			
		});	
	}
	
	$scope.model = { articles: null, filters: { pageFrom: 0, pageTo: 10 } };
	
	/**
	 * Perform Action
	 *
	 * @param articleId, status
	 * @type Int, String
	 */
	$scope.performAction = function(articleId, status) {
		
		$scope.model.sectionLoader = true;
		ArticleService.updateArticleStatus({ articleId: articleId, status: status}).then(function(response){
			
			$scope.model.sectionLoader = false;
			if(response.data.status === true) {
				growl.success(response.data.msg, {ttl: 5000});
				$state.transitionTo($state.current, $stateParams, {
					reload: true,
					inherit: false,
					notify: true
				});
			} else {
				growl.error("Error while loading the articles", {ttl: 5000});
			}
			
		});	
	}
	
	// init
	init();
	
}]);

/**
 * Category Controller
 */

app.controller('CategoryController', ['$scope', '$state', '$stateParams', 'growl', 'CategoryService', function($scope, $state, $stateParams, growl, CategoryService){
	
	/**
	 * Init
	 *
	 * @param null
	 */
	function init() {
		$scope.model.sectionLoader = false;
		
		// Edit Mode
		if($stateParams.categoryId > 0) {
			
			$scope.model.sectionLoader 	= false;
			$scope.model.editMode 		= true;
			$scope.model.categoryId	 	= $stateParams.categoryId;
			CategoryService.getCategoryById({ categoryId: $scope.model.categoryId }).then(function(response){
				
				$scope.model.sectionLoader = false;
				if(response.data.status === true) {
					$scope.model.formData = response.data.categoryData;
					
				} else {
					growl.error("Error while retriving the category", {ttl: 5000});
				}
				
			});
		}
	}
	
	$scope.model = { editMode: false, sectionLoader: true, formData: { categoryId: null, categoryName: '', title: '', keyword: '', description: '' } };
	
	/**
	 * Save
	 *
	 * @param null
	 */
	$scope.save = function() {
		
		// Validation
		if($scope.model.formData.categoryName == '') {
			
			growl.error('Enter category name',  {ttl: 5000} );
			return false;
		}
		
		if($scope.model.formData.title == '') {
			
			growl.error('Enter title',  {ttl: 5000} );
			return false;
		}
		
		if($scope.model.formData.keyword == '') {
			
			growl.error('Enter keyword',  {ttl: 5000} );
			return false;
		}
		
		if($scope.model.formData.description == '') {
			
			growl.error('Enter description',  {ttl: 5000} );
			return false;
		}
		
		$scope.model.sectionLoader = true;
		CategoryService.saveCategory($scope.model.formData).then(function(response){
			
			$scope.model.sectionLoader = false;
			if(response.data.status === true) {
				growl.success(response.data.msg, {ttl: 5000});
				$state.forceReload();
			} else {
				growl.error("Error while saving the category", {ttl: 5000});
			}
		});
	};
	
	// init
	init();
	
}]);

/**
 * Category List Controller
 */

app.controller('CategoryListController', ['$scope', 'CategoryService', function($scope, CategoryService){

	/**
	 * Init
	 *
	 * @param null
	 */
	function init() {
		
		$scope.model.sectionLoader = true;
		CategoryService.getCategories().then(function(response){
			
			$scope.model.sectionLoader = false;
			if(response.data.status === true) {
				$scope.model.categories = response.data.categories;
			} else {
				growl.error("Error while loading the categories", {ttl: 5000});
			}
			
		});	
	}
	
	$scope.model = { categories: null };
	
	// init
	init();
	
}]);

/**
 * Dashboard Controller
 */

app.controller('DashboardController', ['$scope', function($scope){

	console.log('Dashboard');
	
}]);

/**
 * Login Controller
 */

app.controller('LoginController', ['$scope', '$timeout', '$state', 'growl', 'LoginService', function($scope, $timeout, $state, growl, LoginService){
	
	$scope.model = { formData: { username: '', password: '' } };
	
	$timeout(function(){
		$scope.model.showLoginScreen = true;
	}, 500);
	
	/**
	 * Init
	 *
	 * @param null
	 */
	function init() {
		
		// Check the session
		LoginService.sessionCheck().then(function(response){
			if(response.data.status === true) {
				$state.go('app.dashboard');
			}
		});
	}
	
	/**
	 * Login
	 *
	 * @param null
	 */
	$scope.loginSubmission = function() {
		
		//Validation
		if($scope.model.formData.username == '' || $scope.model.formData.password == '') {
			
			growl.error("Username/Password shouldn't be blank", {ttl: 5000});
			return false;
		}
		
		LoginService.login($scope.model.formData).then(function(response){
			
			if(response.data.status === true) {
				growl.success("Authentication success", {ttl: 5000});
				$state.go('app.dashboard');
			} else {
				growl.error("Invalid authentiation", {ttl: 5000});
			}
		});
	};
	
	init();
}]);
