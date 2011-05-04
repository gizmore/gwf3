<?php if ($tVars['nav']) { ?>
	<?php echo GWF_Website::getBanners('forum', 'forum'); ?>
	<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>
<?php } ?>
<?php echo $tVars['form']; ?>
