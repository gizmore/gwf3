<?php echo WC_HTML::accountButtons(); ?>

<?php
$user = GWF_Session::getUser();

if (false !== ($mod_gb = GWF_Module::getModule('Guestbook'))) {
	$mod_gb->onInclude();
	if (false !== ($gb = $mod_gb->getGuestbook($user->getID()))) {
		echo GWF_Button::generic(WC_HTML::lang('btn_manage_gb'), $gb->hrefEdit());
	}
	elseif ($mod_gb->canCreateGuestbook($user)) {
		echo GWF_Button::generic(WC_HTML::lang('btn_manage_gb'), Module_WeChall::hrefCreateGB());
	}
}
//
//if (false !== ($mod_ug = GWF_Module::getModule('Usergroups'))) {
//	if ($mod_ug->hasGroup($user)) {
//		echo GWF_Button::generic(WC_HTML::lang('btn_manage_ug'), $mod_ug->hrefEdit($user->getID()));
//	}
//	elseif ($mod_ug->canCreateGroup($user)) {
//		echo GWF_Button::generic(WC_HTML::lang('btn_manage_ug'), $mod_ug->hrefCreate());
//	} 
//}
?>
<h1><?php echo $tLang->lang('ft_settings'); ?></h1>
<p><?php echo $tLang->lang('pi_help'); ?></p>
<?php
echo $tVars['form'];
?>