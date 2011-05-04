<div class="gwf_tabs">
<?php
$sel2 = Common::getGet('build_forum') !== false;
$sel = $sel2 ? false : Common::getGet('me') === 'Admin';
echo GWF_Button::generic($tLang->lang('btn_news'), $tVars['module']->getAdminSectionURL(), 'generic', '', $sel);
echo GWF_Button::generic($tLang->lang('btn_build_forum'), $tVars['module']->getMethodURL('Admin', '&build_forum=yes'), '', $sel2);
?>
</div>
