<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

$this->load->view('head');

?>

<body ng-cloak>
	<!-- Horizontal Line -->
	<div class="hr-line red"></div>
	
	<div class="container">
		
		<?php $this->load->view('header'); ?>
		
		<div class="row">
			<!-- Content -->
			<div class="col-lg-12">
				<h1 class="text-center v-offset-bottom-25px">The page you are looking for is not found (404)</h1>
				
			</div>
			<!-- /Content -->
			
		</div>
		
	</div>
	<?php $this->load->view('footer'); ?>