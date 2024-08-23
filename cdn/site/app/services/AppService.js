/**
 * App Web Service
 * Name: AppService
 */
app.service('AppService', ['$timeout', '$rootScope', '$http', 'growl', function ($timeout, $rootScope, $http, growl) {
	
	/**
	 * var declaration
	 */
	var AppServiceOp = {};
	
	/**
	 * Check JSON
	 *
	 * Name: isJson
	 * @param: data
	 * @type: jsonArray/jsonObject
	 */
	AppServiceOp.isJson = function(response) {
		var contentType = typeof response;
		contentType.toLowerCase();
		
		if(contentType == 'json' || contentType == 'object'){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Check exception
	 *
	 * Name: checkException
	 * @param: data
	 * @type: jsonArray
	 */
	AppServiceOp.checkNetworkException = function(response) {
		
		// If the response is not empty
		if(!response) {
			AppServiceOp.systemError();
			return false;
		}
		
		// If the response is not JSON
		if(!AppServiceOp.isJson(response.data)) {
			AppServiceOp.systemError();
			return false;
		}
		
		// If the response has any exception
		if(response.data.exception !== null) {
			if(response.data.exception.status) {
				AppServiceOp.systemError(response.data.exception.msg);
				return false;
			}
		}
		return true;
	};

	/**
	 * System error
	 *
	 * @param: msg
	 * @type: String
	 */
	AppServiceOp.systemError = function(msg) {
		
		if(msg) {
			growl.error(msg, { ttl: 3000 });
		} else {
			growl.error('Something went wrong! Server is not giving expected response. Try again later', { ttl: 3000 });
		}
	};
	
	/**
	 * Return all the methods
	 */
	return AppServiceOp;
	
}]);