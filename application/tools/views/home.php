<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

$this->load->view('head');

?>

<body ng-cloak>
	<!-- Horizontal Line -->
	<div class="hr-line red"></div>
	
	<div>
		
		<?php $this->load->view('header'); ?>
		
		<div class="container">
			<div class="row">
				<!-- Articles -->
				<div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
					
					<?php
					
					$i = 0;
					foreach($articles as $article) {
						
						$i = $i + 1;
						$article_id				= $article["article_id"];
						$article_topic			= $article["article_topic"];
						$article_category_id	= $article["cat_id"];
						$article_category_name	= $article["cat_name"];
						$commentCount			= $article["commentCount"];
						$article_content		= $article["article_content"];
						$article_breadcrumbs	= $article["article_breadcrumbs"];
						$posted_date			= $article["posted_date"];
						$posted_date			= date_create($posted_date);
						
						$article_url_compressed	= cleanString($article_topic);
						
						$article_url 			=  base_url('article/'.$article_id."/".$article_url_compressed."/");
						
						$article_social_url		= base_url('article/'.$article_id."/".$article_url_compressed);
						$article_content		= explode("<p>/*****/</p>", $article_content);
					?>
					<div class="blog_articles" itemscope itemtype="http://schema.org/TechArticle">
						<h2 itemprop="name" class="v-offset-top-0px"><a itemprop="url" href="<?php echo $article_url; ?>"><?php echo $article_topic; ?></a></h2>
						
						<div class="breadcrumbs" itemprop="keywords">
							<ul>
								<?php
								$article_breadcrumbs = explode(", ", $article_breadcrumbs);
								foreach($article_breadcrumbs as $breadcrumb) {
									if($breadcrumb != ""){
								?>
								<li itemprop="name"><a href="<?php echo $article_url; ?>"><?php echo $breadcrumb; ?></a></li>
								<?php
									}
								}
								?>
							</ul>
						</div>
						
						<div class="clearfix"></div>
						
						<div class="v-offset-top-10px v-offset-bottom-10px">
							<span class="text-muted" itemprop="datePublished" content="<?php echo date_format($posted_date, 'Y-m-d'); ?>"><?php echo date_format($posted_date, 'l jS F Y'); ?></span>
						</div>
						
						<div class="v-offset-top-10px v-offset-bottom-10px">
							<div itemreviewed="<?php echo $article_topic; ?>">
								<div class="row">
									<div class="col-lg-3 text-muted">
										Author: <span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name" itemprop="author">Mohamed Asif</span></span>
									</div>
									<div class="col-lg-3 text-muted">
										<span>{ <span rel="author" itemprop="commentCount"><?php echo $commentCount; ?></span> Comments }</span>
									</div>
								</div>
							</div>
						</div>
						
						<article itemprop="articleBody">
							<div class="pull-left v-offset-right-5px">
								<div class="fb-like" data-href="<?php echo $article_url; ?>" data-send="false" data-layout="box_count" data-show-faces="false"></div>
							</div>
							<article itemprop="articleSection">
								<?php echo $article_content[0]; ?>
							</article>
							<div class="clearfix"></div>
						</article>
						<div class="hr"></div>
					</div>
					<?php 
					}
					?>
					
					<?php if(isset($pagination)) { ?>
					<div class="text-center">
						<?php echo $pagination; ?>
					</div>
					<?php } ?>
				</div>
				<!-- /Articles -->
				
				<!-- Right Section -->
				<?php $this->load->view('right'); ?>
				<!-- /Right Section -->
			</div>
		</div>
	</div>
	<?php $this->load->view('footer'); ?>