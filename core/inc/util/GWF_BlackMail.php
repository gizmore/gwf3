<?php
/**
 * A table of blacklisted domains.
 * Should be used in registration module, and maybe account changes.
 * @author gizmore
 */
final class GWF_BlackMail extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'email_blacklist'; }
	public function getColumnDefines()
	{
		return array(
			'eb_domain' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		);
	}

	public static function isBlacklisted($email)
	{
		if (false === ($domain = Common::substrFrom($email, '@', false)))
		{
			$domain = $email;
		}
		$domain = self::escape($domain);
		return self::table(__CLASS__)->selectVar('1', "eb_domain='{$domain}'") !== false;
	}

	public static function addToBlacklist($email)
	{
		if (false === ($domain = Common::substrFrom($email, '@', false)))
		{
			$domain = $email;
		}
		if (self::isBlacklisted($domain))
		{
			return true;
		}
		return self::table(__CLASS__)->insertAssoc(array('eb_domain'=>$domain), false);
	}
}
