<?php

final class GWF_ChatValidator
{
	public static function validate_yournick(Module_Chat $module, $arg)
	{
		$arg = trim($arg);
		$_POST['yournick'] = $arg;
		
		if (false === ($oldnick = $module->getNickname())) { # No Nick yet
			if (!GWF_Validator::isValidUsername($arg)) { # Valid
				return $module->lang('err_nick_syntax');
			} else if ($module->isNameTaken($module->getGuestPrefixed($arg))) {
				return $module->lang('err_nick_taken');
			}
			else {
				return false;
			}
		}
		
		if ($oldnick === $arg) {
			return false;
		}
		
		return $module->lang('err_nick_tamper');
	}
	
	public static function validate_target(Module_Chat $module, $arg)
	{
		$arg = trim($arg);
		$_POST['target'] = $arg;
		
		if ($arg === '') {
			if (!$module->checkGuestPublic()) {
				return $module->lang('err_guest_public');
			} else {
				return false;
			}
		}
		
		if (!$module->isPrivateAllowed()) {
			$_POST['target'] = '';
			return $module->lang('err_private');
		}
		
		if (!$module->checkGuestPrivate()) {
			$_POST['target'] = '';
			return $module->lang('err_guest_private');
		}
		
		if (!$module->targetExists($arg)) {
			$_POST['target'] = '';
			return $module->lang('err_target');
		}

		if (!$module->targetValid($arg)) {
			$_POST['target'] = '';
			return $module->lang('err_target_invalid');
		}
		
		return false;
	}
	
	public static function validate_message(Module_Chat $module, $arg)
	{
		$arg = trim($arg);
		$_POST['message'] = $arg;
		if (0 === ($len = strlen($arg))) {
			return $module->lang('err_msg_short');
		}
		$maxlen = $module->getMaxMessageLength();
		if ($len > $maxlen) {
			return $module->lang('err_msg_long', array( $maxlen));
		}
		return false;
	}	
}