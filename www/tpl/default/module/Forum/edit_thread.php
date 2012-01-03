<?php
echo $tVars['form'];
if (!$tVars['thread']->hasPoll()) {
	echo GWF_Button::generic($tLang->lang('btn_add_poll'), $tVars['href_add_poll']);
}
?>
