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