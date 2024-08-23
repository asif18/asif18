<nav class="navbar navbar-default main-menu">
	
	<div class="container">
		<div class="navbar-header">
			<button type="button" ng-class="{ 'active': !model.collapseMainMenu }" class="navbar-toggle" ng-click="model.collapseMainMenu = !model.collapseMainMenu">
				<em class="fa fa-align-justify"></em>                        
			</button>
		</div>
	
		<div class="collapse navbar-collapse" uib-collapse="model.collapseMainMenu">
			<?php $category = isset($category) ? $category : ''; ?>
			<ul class="nav navbar-nav" itemscope itemtype="http://schema.org/ReadAction">
				<li><a itemprop="url" href="<?php echo base_url(); ?>">Articles</a></li>
				<li class="<?php echo ($category == 'jquery') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/jquery/'); ?>">jQuery</a></li>
				<li class="<?php echo ($category == 'css') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/css/'); ?>">CSS3</a></li>
				<li class="<?php echo ($category == 'php') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/php/'); ?>">PHP</a></li>
				<li class="<?php echo ($category == 'angularjs') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/angularjs/'); ?>">Angular JS</a></li>
				<li class="<?php echo ($category == 'oracle') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/oracle/'); ?>">Oracle</a></li>
				<li class="<?php echo ($category == 'wordpress') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/wordpress/'); ?>">WordPress</a></li>
				<li class="<?php echo ($category == 'facebook') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/facebook/'); ?>">Facebook</a></li>
				<li class="<?php echo ($category == 'google') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/google/'); ?>">Google</a></li>
				<li class="<?php echo ($category == 'twitter') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/twitter/'); ?>">Twitter</a></li>
				<li class="<?php echo ($category == 'paypal') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('article/15/simple-paypal-integration-code-using-php-ready-to-use-script/'); ?>">Paypal</a></li>
				<li class="<?php echo ($category == 'challenges') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/challenges/'); ?>">Challenges</a></li>
			</ul>
		</div>
	</div>
</nav>