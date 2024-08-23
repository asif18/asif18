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
