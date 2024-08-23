<div itemscope itemtype="http://schema.org/ReadAction">
	<h4>More Articles</h4>
	
	<div class="related-articles list-group">
		<?php 
		foreach($relatedArticles as $article) {
			$article_id				= $article["article_id"];
			$article_topic			= $article["article_topic"];
			$category 				= $article["cat_name"];
			$article_url_compressed	= cleanString($article_topic);
			$article_url 			= base_url('article/'.$article_id."/".$article_url_compressed."/");
		?>
		<a itemprop="name" href="<?php echo $article_url; ?>" class="list-group-item"><?php echo $article_topic; ?></a>
		<?php 
		}
		?>
	</div>
</div>