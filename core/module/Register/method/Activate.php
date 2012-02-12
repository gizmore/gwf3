<?php
/**
 * Activate a user.
 * Features optional auto-login after activation.
 * @author gizmore
 */
final class Register_Activate extends GWF_Method
{
	public function getHTAccess()
	{
		return 
			'RewriteRule ^activate/([a-zA-Z0-9]+)$ index.php?mo=Register&me=Activate&token=$1&mail=yes'.PHP_EOL.
			'RewriteRule ^quick_activate/([a-zA-Z0-9]+)$ index.php?mo=Register&me=Activate&token=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if ('' !== ($token = Common::getGetString('token')))
		{
			return self::onActivate($this->module, $token, (Common::getGet('mail')!==false));
		}
	}
	
	public static function onActivate(Module_Register $module, $token, $byEmail)
	{
		$ua = GDO::table('GWF_UserActivation');
		if (false === ($row = $ua->getBy('token', $token)))
		{
			return $module->error('err_activate');
		}

		if ($module->hasIPActivatedRecently())
		{
			return $module->error('err_ip_timeout');
		}
		
		$options = $byEmail === true ? GWF_User::MAIL_APPROVED : 0;
		$username = $row->getVar('username');
		$countryid = $row->getVar('countryid');
		$user = new GWF_User(array(
			'user_id' => 0,
			'user_options' => $options,
			'user_name' => $username,
			'user_password' => $row->getVar('password'),
			'user_regdate' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'user_regip' => $row->getVar('ip'),
			'user_email' => $row->getVar('email'),
			'user_gender' => 'no_gender',
			'user_lastlogin' => 0,
			'user_lastactivity' => time(),
			'user_birthdate' => $row->getVar('birthdate'),
			'user_avatar_v' => 0,
			'user_countryid' => $countryid,
			'user_langid' => GWF_LangMap::getPrimaryLangID($countryid),
			'user_langid2' => 0,
			'user_level' => 0,
			'user_title' => '',
			'user_settings' => '',
			'user_data' => '',
			'user_credits' => '0.00',
		));
		
		if (false === ($user->insert()))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === ($ua->deleteWhere(sprintf('username=\'%s\'', $username))))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return self::onActivated($module, $user);
	}
	
	private static function onActivated(Module_Register $module, GWF_User $user)
	{
		if (false === GWF_Hook::call(GWF_Hook::ACTIVATE, $user, array(true)))
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if ($module->wantAutoLogin())
		{
			if (false === GWF_Session::onLogin($user))
			{
				return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			}
			GWF_Website::redirect(GWF_WEB_ROOT.'welcome');
		}
		else
		{
			return $module->message('msg_activated');
		}
	}
}
?>
