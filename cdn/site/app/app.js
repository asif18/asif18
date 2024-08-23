var app;

/**
 * Create the asif18 module
 */
app = angular.module('asif18', ['ui.bootstrap', 'ngAnimate', 'angular-growl', 'ngSanitize', 'vcRecaptcha']);

angular.element( document.getElementsByTagName('pre')).addClass('prettyprint');

app.config(['growlProvider', function(growlProvider) {
	
	//Growl
	growlProvider.onlyUniqueMessages(true);
	
}]);