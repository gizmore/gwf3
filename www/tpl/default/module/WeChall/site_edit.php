<?php
echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::forward($tVars['href_update_all'], $tLang->lang('btn_update_all'));
echo GWF_Button::user($tVars['href_update_one'], $tLang->lang('btn_update_one'));
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;

echo GWF_Button::generic($tLang->lang('btn_edit_site_descr'), $tVars['href_edit_descr']);
echo GWF_Button::generic($tLang->lang('btn_warboxes'), $tVars['href_edit_boxes']);
//echo sprintf('<');

echo $tVars['form'];
echo $tVars['form_logo'];
echo $tVars['form_site_admin'];
?>
