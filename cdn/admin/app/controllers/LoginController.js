/**
 * Login Controller
 */

app.controller('LoginController', ['$scope', '$timeout', '$state', 'growl', 'LoginService', function($scope, $timeout, $state, growl, LoginService){
	
	$scope.model = { formData: { username: '', password: '' } };
	
	$timeout(function(){
		$scope.model.showLoginScreen = true;
	}, 500);
	
	/**
	 * Init
	 *
	 * @param null
	 */
	function init() {
		
		// Check the session
		LoginService.sessionCheck().then(function(response){
			if(response.data.status === true) {
				$state.go('app.dashboard');
			}
		});
	}
	
	/**
	 * Login
	 *
	 * @param null
	 */
	$scope.loginSubmission = function() {
		
		//Validation
		if($scope.model.formData.username == '' || $scope.model.formData.password == '') {
			
			growl.error("Username/Password shouldn't be blank", {ttl: 5000});
			return false;
		}
		
		LoginService.login($scope.model.formData).then(function(response){
			
			if(response.data.status === true) {
				growl.success("Authentication success", {ttl: 5000});
				$state.go('app.dashboard');
			} else {
				growl.error("Invalid authentiation", {ttl: 5000});
			}
		});
	};
	
	init();
}]);
