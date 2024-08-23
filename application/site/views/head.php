<!DOCTYPE html>
<!-- Microdata markup added by Google Structured Data Markup Helper. -->
<html dir="ltr" lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:b="http://www.google.com/2005/gml/b" xmlns:data="http://www.google.com/2005/gml/data" xmlns:expr="http://www.google.com/2005/gml/expr" ng-app="asif18" prefix="og: http://ogp.me/ns#">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="author" content="<?php echo ucfirst(SITE_NAME); ?>">
<link rel="icon" type="image/x-icon" href="<?php echo assets_url('site/img/favicon.ico'); ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title><?php echo $title; ?></title>

<?php if(ENVIRONMENT == 'local') { ?>
<link rel="stylesheet" href="<?php echo assets_url('site/css/bootstrap.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo assets_url('site/css/font-awesome.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo assets_url('site/css/angular-growl.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo assets_url('site/css/style.css'); ?>" />
<?php } else { ?>
<link rel="stylesheet" href="<?php echo assets_url('site/build/style.min.css'); ?>" />
<?php } ?>

<meta name="description" content="<?php echo $description; ?>" />
<meta name="keywords" content="<?php echo $keywords; ?>" />
<link rel="canonical" href="<?php echo $canonicalUrl; ?>" />
<meta name="google-site-verification" content="Xd3WiTbRj16wjMGyxZPwjBqn1gsVT1mQgW3eK4742Yo" />
<meta name="msvalidate.01" content="F176368E419F85702C42E52F28CBC3CC" />
<meta itemprop="image" content="<?php echo assets_abs_url('site/img/asif18-logo.png'); ?>">

<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $keywords; ?> - <?php echo ucfirst(SITE_NAME); ?>" />
<meta property="og:description" content="<?php echo $description; ?>" />
<meta property="og:url" content="<?php echo $canonicalUrl; ?>" />
<meta property="og:site_name" content="<?php echo ucfirst(SITE_NAME); ?>" />
<meta property="article:publisher" content="https://www.facebook.com/mohamedasif18asif18" />
<meta property="article:author" content="https://www.facebook.com/mohamedasif18asif18" />
<?php
foreach(explode(',', $keywords) as $tag) {
?>
<meta property="article:tag" content="<?php echo trim($tag); ?>" />
<?php 
}
?>
<meta property="article:section" content="<?php $section; ?>" />
<meta property="article:published_time" content="<?php echo $publishedDate; ?>" />
<meta property="article:modified_time" content="<?php echo $updatedDate; ?>" />
<meta property="og:updated_time" content="<?php echo $updatedDate; ?>" />
<meta property="og:image" content="<?php echo assets_abs_url('site/img/asif18-logo.png'); ?>" />
<meta property="og:image:width" content="<?php echo $imageWidth; ?>" />
<meta property="og:image:height" content="<?php echo $imageHeight; ?>" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?php echo $description; ?>" />
<meta name="twitter:title" content="<?php echo $title; ?>" />
<meta name="twitter:site" content="@mohamedasif18" />
<meta name="twitter:image" content="<?php echo assets_abs_url('site/img/asif18-logo.png'); ?>" />
<meta name="twitter:creator" content="@mohamedasif18" />
<meta property="og:image" content="<?php assets_url('site/img/asif18-logo.png'); ?>"/>
<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:url" content="<?php echo base_url(); ?>"/>
<meta property="og:site_name" content="<?php echo ucfirst(SITE_NAME); ?>"/>
<meta property="og:type" content="blog"/>

<link rel="alternate" type="application/rss+xml" title="My RSS Feed" href="<?php echo base_url('feed'); ?>" />

</head>