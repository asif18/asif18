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