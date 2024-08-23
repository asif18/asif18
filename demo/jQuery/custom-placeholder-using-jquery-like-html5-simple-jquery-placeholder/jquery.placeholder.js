jQuery.fn.extend({
	placeholder : function(){
		this.each(function() {
			$(this).addClass('placeholder_click');
			var tagName = $(this).get(0).tagName;
			$(this).focus(function() {				  
				if(tagName == 'SELECT'){
					$(this).removeClass('placeholder_click');	
				}
				else{
					if ($(this).val() == $(this).prop('defaultValue')) {
					  $(this).val('');
					  $(this).removeClass('placeholder_click');	
					  var ChkPassword = $(this).hasClass("password");
						if(ChkPassword == true){
							 $(this).get(0).type='password';
						}
					}
				}
			});
			$(this).blur(function() {
				if ($(this).val() == '') {
					$(this).addClass('placeholder_click');
					$(this).val($(this).prop('defaultValue'));
					var ChkPassword = $(this).hasClass("password");
					if(ChkPassword == true){
						 $(this).get(0).type='text';
					}
				} 
			});
	   });
	}
});