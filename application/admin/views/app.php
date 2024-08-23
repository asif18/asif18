<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en" ng-app="admin">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>{{ vm.pageTitle }}</title>
<link rel="shortcut icon" href="<?php echo assets_url('admin/img/favicon.ico'); ?>" />
<?php if(ENVIRONMENT == 'local') { ?>
<link rel="stylesheet" href="<?php echo assets_url('admin/css/bootstrap.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo assets_url('admin/css/font-awesome.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo assets_url('admin/css/angular-growl.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo assets_url('admin/css/style.css'); ?>" />
<?php } else { ?>
<link rel="stylesheet" href="<?php echo assets_url('admin/build/style.min.css'); ?>" />
<?php } ?>
</head>

<body ng-controller="AppController" ng-class="{ 'login-body': (currentState == 'login.loginpage') }" ng-cloak>
<sectionloader loading="vm.pageLoader"></sectionloader>
<div growl></div>
<section ui-view="login"></section>
<section ui-view="app"></section>

<script type="text/javascript">var APPCONFIG = <?php echo json_encode($appConfig); ?></script>
<?php if(ENVIRONMENT == 'local') { ?>
<!-- Core JS files -->
<script type="text/javascript" src="<?php echo assets_url('admin/js/angular/angular.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/js/bootstrap/ui-bootstrap-tpls-2.5.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/js/uirouter/angular-ui-router.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/js/growl/angular-growl.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/js/angular-animate/angular-animate.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/js/ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/js/ckeditor/angular-ckeditor.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/js/properties.js'); ?>"></script>
<!-- App JS files -->
<script type="text/javascript" src="<?php echo assets_url('admin/app/app.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/filters/filters.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/directives/preloader.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/services/AppService.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/services/LoginService.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/services/ArticleService.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/services/CategoryService.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/controllers/AppController.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/controllers/LoginController.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/controllers/DashboardController.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/controllers/ArticleController.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/controllers/ArticleListController.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/controllers/CategoryController.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/app/controllers/CategoryListController.js'); ?>"></script>
<?php } else { ?>
<script type="text/javascript" src="<?php echo assets_url('admin/js/ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/js/pretty-print/run_prettify.js?lang=css&skin=desert'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/build/core.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('admin/build/app.min.js'); ?>"></script>
<?php } ?>
</body>
</html>