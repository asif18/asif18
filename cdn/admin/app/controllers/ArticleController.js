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
