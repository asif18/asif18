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
