<!-- Banner Ads -->
<?php echo GWF_Website::getBanners('forum', 'forum'); ?>
<?php echo WC_HTML::accountButtons(); ?>
<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>
<?php echo $tVars['form']; ?>