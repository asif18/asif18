<div class="breadcrumb-tags v-offset-bottom-10px v-offset-top-10px">
	<?php
	foreach($breadCrumbs as $breadcrumb) {
		
		if(strpos($breadcrumb, '|') > 0) {
			$breadcrumb = explode('|', $breadcrumb);
			echo '<span><a href="'.$breadcrumb[1].'">'.$breadcrumb[0].'</a></span> ';
		}
	}
	?>
</div>