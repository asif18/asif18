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