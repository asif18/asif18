<footer class="footer v-offset-top-15px v-offset-bottom-15px">
	<div class="container">
		<div class="hr-line blue v-offset-bottom-10px"></div>
		<div class="row">
			<div class="col-lg-2 text-left text-xs-center">
				
				<img src="<?php echo assets_url('site/img/html-5-50X50.png'); ?>" alt="HTML 5" uib-tooltip="HTML5" class="img-responsive inline-block" />
		
				<img src="<?php echo assets_url('site/img/bootstrap-ui-50X50.png'); ?>" alt="Bootstrap UI" uib-tooltip="Bootstrap UI" class="img-responsive inline-block" />
		
				<img src="<?php echo assets_url('site/img/angular-50X50.png'); ?>" alt="Angular JS" uib-tooltip="Angular JS" class="img-responsive inline-block" />
				
			</div>
			
			<div class="col-lg-8 text-center">
				<article class="text-center">Powered by <a href="//plus.google.com/102644259301015068991" target="_blank">Mohamed Asif&nbsp;&nbsp;<img src="<?php echo assets_url('site/img/favicon.ico'); ?>" alt="Asif-18"/></a></article>
				<div class="cleatfix"></div>
				<small class="v-offset-top-5px text-center">&copy 2012 - <?php echo date('Y').' '.base_url(); ?> version 2.1.3. While using this site, you agree to have read and accepted our <a href="<?php echo base_url('terms'); ?>">terms and conditions</a> and <a href="<?php echo base_url('terms/cookies'); ?>">cookies policy</a> All Rights Reserved. </small>
			</div>
			
			<div class="col-lg-2 text-right text-xs-center ">
				<img src="<?php echo assets_url('site/img/make-in-india-logo.png'); ?>" alt="Angular JS" uib-tooltip="Make In India" class="img-responsive inline-block"/>
			</div>
		</div>
	</div>
</footer>
	
<!-- Horizontal Line -->
<div class="hr-line red"></div>

<!-- Facebook Root -->
<div id="fb-root"></div>
<script type="text/javascript" src="<?php echo site_url('script'); ?>"></script>
<?php if(ENVIRONMENT == 'local') { ?>
<!-- Core JS files -->
<script type="text/javascript" src="<?php echo assets_url('site/js/angular/angular.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/js/angular-sanitize/angular-sanitize.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/js/bootstrap/ui-bootstrap-tpls-2.5.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/js/angular-animate/angular-animate.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/js/growl/angular-growl.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/js/angular-recaptcha/angular-recaptcha.min.js'); ?>"></script>
<!-- App JS files -->
<script type="text/javascript" src="<?php echo assets_url('site/app/app.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/app/filters/filters.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/app/directives/preloader.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/app/directives/comments.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/app/services/AppService.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/app/services/CommentService.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('site/app/controllers/HeaderController.js'); ?>"></script>
<?php } else { ?>
<script defer type="text/javascript" src="<?php echo assets_url('site/build/core.min.js'); ?>"></script>
<script defer type="text/javascript" src="<?php echo assets_url('site/build/app.min.js'); ?>"></script>
<?php } ?>
<script defer type="text/javascript" src="<?php echo assets_url('site/js/pretty-print/run_prettify.js?lang=css&skin=desert'); ?>"></script>
<script type="text/javascript">

// Facebook
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=479512955465280";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// gPlus
(function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();

// Twitter
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

</script>

<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-40268363-1', 'asif18.com');
ga('send', 'pageview');

</script>
</body>
</html>