<?php
/**
 * Fake guest user.
 * @author gizmore
 * @version 3.0
 */
final class GWF_Guest
{
	/**
	 * Get a fake Guest User.
	 * @return GWF_User
	 */
	public static function getGuest()
	{
		static $GUEST;
		if (!isset($GUEST))
		{
			$GUEST = new GWF_User(array(
				'user_id' => '0',
				'user_options' => 0,#GWF_User::IS_GUEST|$bot,
				'user_name' => GWF_HTML::lang('guest'),
				'user_password' => '',
				'user_regdate' => '',
				'user_regip' => GWF_IP6::getIP(GWF_IP_EXACT),
				'user_email' => '',
				'user_gender' => GWF_User::NO_GENDER,
				'user_lastlogin' => '0',
				'user_lastactivity' => time(),
				'user_birthdate' => '',
				'user_avatar_v' => '0',
				'user_countryid' => '0',
				'user_langid' => '0',
				'user_langid2' => '0',
				'user_level' => '0',
				'user_title' => '',
				'user_settings' => '',
				'user_data' => '',
				'user_credits' => '0.00',
			));
		}
		return $GUEST;
	}
}

