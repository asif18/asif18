<div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
	<div class="authorinfo" itemscope itemtype="http://schema.org/Person">
		
		<?php 
		//$this->load->view('author');
		?>
		
		<div class="text-center">
			<?php $this->load->view('gplus_author'); ?>
		</div>
		
		<div class="text-center">
			<?php $this->load->view('twitter_follow'); ?>
		</div>
		
	</div>
	
	<div class="fb_like_box text-center">
		<?php $this->load->view('fb_like_box'); ?>
	</div>
	
	<br/>
	
	<div class="text-center">
		<?php $this->load->view('right_add_block_sm_1'); ?>
	</div>
	
	<?php $this->load->view('more_articles'); ?>
	
	<!-- HomeRightBottom -->
	<div class="text-center">
		<?php $this->load->view('right_add_block_lg_1'); ?>
	</div>
	
	<div class="text-center">
		<?php $this->load->view('gplus_page'); ?>
	</div>
	
	<?php $this->load->view('breadcrumb_tags'); ?>
	
</div>