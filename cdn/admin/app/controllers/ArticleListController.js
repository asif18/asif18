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
