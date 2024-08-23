<?php
header('Content-Type: application/xml');
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset
      xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
      xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
      xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
$xml .= "<url>
	<loc>http://www.asif18.com/</loc>
</url>\n";
$url_prefix = base_url();

foreach($articles as $article){
	
	$article_id				 = $article["article_id"];
	$article_topic			 = $article["article_topic"];
	$posted_date			 = $article["posted_date"];
	$posted_date			 = date_create($posted_date);
	$category 				 = $article["cat_name"];
	$article_url_compressed	 = cleanString($article_topic);
	$article_url 			 = "article/".$article_id."/".$article_url_compressed."/";
	$article_demo_url 		 = $article["article_demolink"];
	$frequency				 = "daily";
	$priority				 = "0.1";
	$xml .= "<url>
	<loc>".$url_prefix.$article_url."</loc>
	<lastmod>".date_format($posted_date, 'Y-m-d')."</lastmod>
</url>\n";
	if($article_demo_url != ""){
		$xml .= "<url>
	<loc>".$article_demo_url."</loc>
	<lastmod>".date_format($posted_date, 'Y-m-d')."</lastmod>
	<changefreq>".$frequency."</changefreq>
	<priority>".$priority."</priority>
</url>\n";
	}
}

foreach($categories as $category) {
	
	if($category['cat_name'] == "php"){
		$category['cat_name'] = "PHP";
	}
	$category_posted_date	 = $category["raw_post_date"];
	$category_posted_date	 = date_create($category_posted_date);
	$category_url_compressed = "/".str_replace(" ", "-", $category['cat_name']);
	$frequency				 = "daily";
	$priority				 = "0.1";
	$xml .= "<url>
	<loc>".$url_prefix.$category_url_compressed."/</loc>
	<lastmod>".date_format($category_posted_date, 'Y-m-d')."</lastmod>
	<changefreq>".$frequency."</changefreq>
	<priority>".$priority."</priority>
</url>\n";
}

foreach($articles as $article){
	
	$article_id				 = $article["article_id"];
	$article_topic			 = $article["article_topic"];
	$posted_date			 = $article["posted_date"];
	$posted_date			 = date_create($posted_date);
	$category 				 = $article["cat_name"];
	$category_url_compressed = cleanString($category);
	$article_url_compressed	 = cleanString($article_topic);
	$article_url 			 = "comments/".$article_id."/".$article_url_compressed;
	$article_demo_url 		 = $article["article_demolink"];
	$frequency				 = "daily";
	$priority				 = "0.1";
	$xml .= "<url>
	<loc>".$url_prefix.$article_url."</loc>
	<lastmod>".date_format($posted_date, 'Y-m-d')."</lastmod>
</url>\n";
	if($article_demo_url != ""){
		$xml .= "<url>
	<loc>".$article_demo_url."</loc>
	<lastmod>".date_format($posted_date, 'Y-m-d')."</lastmod>
	<changefreq>".$frequency."</changefreq>
	<priority>".$priority."</priority>
</url>\n";
	}
}

$xml .= "</urlset>";
echo $xml;
?>