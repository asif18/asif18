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