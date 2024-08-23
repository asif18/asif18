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
				<li><a itemprop="url" href="<?php echo base_url(); ?>">Home</a></li>
				<li class="<?php echo ($category == 'jquery') ? 'active' : ''; ?>"><a itemprop="url" href="<?php echo base_url('/category/jquery/'); ?>">jQuery</a></li>
			</ul>
		</div>
	</div>
</nav>