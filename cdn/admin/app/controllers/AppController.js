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