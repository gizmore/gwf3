<div id="wanda-content-page">

	<?php echo $tVars['text']; ?>
	
	<div class="wanda-paginator">
		<?php if ($tVars['prev']) { ?>
		<a class="wanda-prev-page" href="<?php echo $tVars['prev']; ?>">«</a>
		<?php } ?>
		<?php if ($tVars['next']) { ?>
		<a class="wanda-next-page" href="<?php echo $tVars['next']; ?>">»</a>
		<?php } ?>
	
		<div id="wanda-book-page-badge"><?php echo $tVars['page']?></div>
	</div>

</div>
