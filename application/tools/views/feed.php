<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Content-Type: application/xml');
ob_start();
$latest_post_date	= date_create($latestArticle['posted_date']);
$description	 	= "asif18.com is a programming blog that describes web tutorials such as facebook components, google coponents, paypal integration. Tutorials related to web languages and libraries such as jquery, ajax, css, html, php, mysql, json, curl, javascript. Describes the funtions, classes, libraries, how to integrate and work in facebook apps, google apps, twitter apps, working with paypal, working with multiple databases and mysql quiries, simple php classes and funtions";
$rss = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss version=\"2.0\">
<channel>  
<title>".ucfirst(SITE_NAME)."</title>
<description>".$description."</description>
<lastBuildDate>".date_format($latest_post_date, "l, F j, Y g:ia")." GMT</lastBuildDate>
<link>".base_url() ."</link>";

foreach($articles as $article){
	
	$article_id				 = $article["article_id"];
	$article_topic			 = $article["article_topic"];
	$article_content		 = $article["article_content"];
	$article_content		 = explode("<p>/*****/</p>", $article_content);
	$article_content		 = $article_content[0];
	$posted_date			 = $article["posted_date"];
	$posted_date			 = date_create($posted_date);
	$category 				 = $article["cat_name"];
	$article_url_compressed	 = cleanString($article_topic);
	$article_url 			 = "article/".$article_id."/".$article_url_compressed."/";
	$article_demo_url 		 = $article["article_demolink"];
	$frequency				 = "daily";
	$priority				 = "0.1";
	$rss .= "<item>
	<title>".$article_topic."</title>
	<description><![CDATA[".$article_content."]]></description>
	<link>".base_url($article_url)."</link>  
    <lastUpdated>".date_format($posted_date, "l, F j, Y g:ia")." GMT</lastUpdated>
</item>\n";
	}
$rss .= "</channel>";
$rss .= "</rss>";
echo ob_get_clean();
echo $rss;
?>
