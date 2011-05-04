<?php # Vars?
$pm = $tVars['pm'];
$pm instanceof GWF_PM;
$a = $tVars['actions'];
$u = GWF_User::getStaticOrGuest();
$s = $pm->getFromID() === $u->getID();

if (isset($tVar['transid'])) {
	$transid = $tVars['transid'];
} else {
	$transid = 'pm_trans_'.$pm->getVar('pm_id');
}

$box = '';
foreach ($tVars['unread'] as $unread)
{
	$box .= '<div>'.GWF_HTML::anchor($unread->getDisplayHREF(), $unread->getVar('pm_title')).'</div>'.PHP_EOL;
}
if ($box !== '') {
	echo '<div class="fl">';
	echo GWF_Box::box($box);
	echo '</div>'.PHP_EOL;
}
?>

<div class="gwf_pm oa">
	<div class="gwf_pm_head">
		<h3><?php echo $tVars['title']; ?></h3>
		<div class="gwf_pm_date gwf_date"><?php echo $pm->displayDate(); ?></div>
		<div class="gwf_pm_sender">
		<?php if ($s) {
			echo $tLang->lang('th_pm_to').'&nbsp;'.$pm->getReceiver()->displayProfileLink();
		 }
		 else {
		 	echo $tLang->lang('th_pm_from').'&nbsp;'.$pm->getSender()->displayProfileLink();
		 }
		?>
		</div>
	</div>
	
	<div class="gwf_pm_body">
		<div class="gwf_pm_msg" id="<?php echo $transid; ?>"><?php echo $tVars['translated'] === '' ? $pm->displayMessage() : $tVars['translated']; ?></div>
		<div class="gwf_pm_sig"><?php echo $pm->displaySignature(); ?></div>
	</div>
	
<?php if ($a) {
		$buttons = '';
	
		if (false !== ($prevs = $pm->getReplyToPrev())) {
			foreach ($prevs as $prev) {
				$buttons .= GWF_Button::prev($prev->getDisplayHREF(), $tLang->lang('btn_prev'));
			}
		}
		else {
//			$buttons .= GWF_Button::prev('#', $tLang->lang('btn_prev'));
		}
	
		if (!$pm->hasDeleted($u)) {
			$buttons .= GWF_Button::delete($pm->getDeleteHREF($u->getID()), $tLang->lang('btn_delete'));
		}
		else {
			$buttons .= GWF_Button::restore($pm->getRestoreHREF(), $tLang->lang('btn_restore'));
		}
		if ($pm->canEdit($u)) {
			$buttons .= GWF_Button::edit($pm->getEditHREF(), $tLang->lang('btn_edit'));
		}
		$buttons .= GWF_Button::options($pm->getAutoFolderHREF(), $tLang->lang('btn_autofolder'));
		if (!$pm->isGuestPM()) {
			$buttons .= GWF_Button::reply($pm->getReplyHREF(), $tLang->lang('btn_reply')).PHP_EOL.GWF_Button::quote($pm->getQuoteHREF(), $tLang->lang('btn_quote'));
		}
		$u2 = $pm->getOtherUser($u);
		$buttons .= GWF_Button::ignore($pm->getIgnoreHREF($pm->getOtherUser($u)), $tLang->lang('btn_ignore', array( $u2->display('user_name'))));
		
		$buttons .= GWF_Button::translate($pm->getTranslateHREF(), $tLang->lang('btn_translate'), '', 'gwfGoogleTrans(\''.$transid.'\'); return false;');
		
		if (false !== ($nexts = $pm->getReplyToNext())) {
			foreach ($nexts as $next) {
				$buttons .= GWF_Button::next($next->getDisplayHREF(), $tLang->lang('btn_next'));
			}
		}
		else {
//			$buttons .= GWF_Button::next('#', $tLang->lang('btn_next'));
		}
		

		echo GWF_HTML::div($buttons, 'gwf_pm_foot');
} ?>
</div>
<div class="cl"></div>
