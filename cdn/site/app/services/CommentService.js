/**
 * Comment Web Service
 * Name: CommentService
 */
app.service('CommentService', ['$http', 'AppService', function ($http, AppService) {
	
	/**
	 * var declaration
	 */
	var AppServiceOp = {};
	
	/**
	 * Get Comments
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.getComments = function(data) {
		
		return $http.post(APPCONFIG.WSURLS.getComments, data).then(function(response){
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
	 * Save Comment
	 *
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.saveComment = function(data) {
		return $http.post(APPCONFIG.WSURLS.saveComment, data).then(function(response){
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