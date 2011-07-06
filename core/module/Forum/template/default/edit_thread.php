<!-- Banner Ads -->
<?php echo GWF_Website::getBanners('forum', 'forum'); ?>

<?php echo $tVars['form']; ?>

<?php if (!$tVars['thread']->hasPoll()) {
	echo GWF_Button::generic($tLang->lang('btn_add_poll'), $tVars['href_add_poll']);
}?>