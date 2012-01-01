<!-- Banner Ads -->
<?php #echo GWF_Website::getBanners('forum', 'forum'); ?>
<?php #echo '<div class="gwf_board_quicktree">'.Module_Forum::getNavTree().'</div>'; ?>
<?php if ($tVars['preview'] === false) { ?>
	<a name="form"></a>
<?php } ?>
<div class="gwf_full_width"><?php echo $tVars['form'] ?></div>