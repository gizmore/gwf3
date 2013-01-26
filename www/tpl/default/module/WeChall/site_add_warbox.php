<?php
echo GWF_Button::wrapStart();
echo GWF_Button::generic($tLang->lang('menu_sites'), $tVars['href_site']);
echo GWF_Button::generic($tLang->lang('btn_edit_site_descr'), $tVars['href_descr']);
echo GWF_Button::generic($tLang->lang('btn_warboxes'), $tVars['href_boxes']);
echo GWF_Button::wrapEnd();

echo $tVars['form'];
?>