<h1><?php echo $tLang->lang('sign_title'); ?></h1>

<p><?php echo $tVars['info']; ?></p>

<?php echo $tVars['form']; ?>

<?php
if ($tVars['subscribed'] === true) {
	echo GWF_Button::generic($tLang->lang('btn_unsign'), $tVars['href_unsign']);
}
?>