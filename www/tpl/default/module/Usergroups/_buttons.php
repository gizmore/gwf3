<div class="gwf_buttons_outer">
<div class="gwf_buttons">
<?php
$m = $tVars['module']; $m instanceof Module_Usergroups;
echo GWF_Button::generic($tLang->lang('btn_users'), $tVars['href_users'], 'generic', '', $m->isMethodSelected('Users'));
echo GWF_Button::generic($tLang->lang('btn_groups'), $tVars['href_groups'], 'generic', '', $m->isMethodSelected('ShowGroups'));
echo GWF_Button::generic($tLang->lang('btn_search'), $tVars['href_search'], 'generic', '', $m->isMethodSelected('Search'));
echo GWF_Button::generic($tLang->lang('btn_gallery'), $tVars['href_gallery'], 'generic', '', $m->isMethodSelected('AvatarGallery'));
?>
</div>
</div>
