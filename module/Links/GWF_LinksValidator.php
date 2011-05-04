<?php
final class GWF_LinksValidator
{
	public static function validate_gid(Module_Links $module, $arg)
	{
		return GWF_Validator::validateGroupID($module, 'gid', $arg, true, true);
	}
	
	public static function validate_score(Module_Links $module, $arg)
	{
		$arg = (int) $arg;
		return $arg >= 0 ? false : $module->lang('err_score');
	}
	
	public static function validate_href(Module_Links $module, $arg, $check_dups)
	{
		$arg = trim($arg);
		$_POST['link_href'] = $arg;
		if (strlen($arg) > $module->cfgMaxUrlLen()) {
			return $module->lang('err_url_long', array( $module->cfgMaxUrlLen()));
		}
		if (false === GWF_Validator::isValidURL($arg)) {
			return $module->lang('err_url');
		}
		if (false === GWF_HTTP::pageExists($arg)) {
			return $module->lang('err_url_down');
		}
		if ($check_dups === true)
		{
			if (false !== GWF_Links::getByHREF($arg)) {
				return $module->lang('err_url_dup');
			}
		}
		return false;
	}
	
	public static function validate_descr1(Module_Links $module, $arg)
	{
		$arg = trim($arg);
		$_POST['descr1'] = $arg;
		$len = strlen($arg);
		$min = $module->cfgMinDescrLen();
		$max = $module->cfgMaxDescrLen();
		if ($len < $min) {
			return $module->lang('err_descr1_short', array( $min));
		}
		if ($len > $max) {
			return $module->lang('err_descr1_long', array( $max));
		}
		return false;
	}
	
	public static function validate_descr2(Module_Links $module, $arg)
	{
		$arg = trim($arg);
		$_POST['descr2'] = $arg;
		$len = strlen($arg);
		$min = $module->cfgMinDescr2Len();
		$max = $module->cfgMaxDescr2Len();
		if ($len < $min) {
			return $module->lang('err_descr2_short', array( $min));
		}
		if ($len > $max) {
			return $module->lang('err_descr2_long', array( $max));
		}
		return false;
	}
	
	public static function validate_tags(Module_Links $module, $arg)
	{
		$errors = array();
		$new = 0;
		$arg = explode(',', trim($arg));
		$taken = array();
		$minlen = 3;
		$maxlen = $module->cfgMaxTagLen();
		foreach ($arg as $tag)
		{
			$tag = trim($tag);
			if (strlen($tag) === 0) {
				continue;
			}
			
			if (false === GWF_LinksTag::getByName($tag))
			{
				if (self::isValidTagName($tag, $minlen, $maxlen))
				{
					$taken[] = $tag;
					$new++;
				}
				else
				{
					$errors[] = $module->lang('err_tag', array(GWF_HTML::display($tag), $minlen, $maxlen));
				}
			}
			else
			{
				$taken[] = $tag;
			}
		}
		
		if (count($taken) === 0) {
			$errors[] = $module->lang('err_no_tag');
		}
		
		$_POST['link_tags'] = implode(',', $taken);
		
		if (count($errors) === 0) {
			return false;
		}
		
		return implode('<br/>', $errors);
	}
	
	private static function isValidTagName($tag, $minlen, $maxlen)
	{
		$len = strlen($tag);
		return $len >= $minlen && $len <= $maxlen;
	}
	
	##################
	### Permission ###
	##################
	public static function mayAddLink(Module_Links $module, $user)
	{
		if (is_object($user)) {
			return GWF_Links::mayUserAddLink($module, $user);
		}
		else {
			return GWF_Links::mayGuestAddLink($module);
		}
	}
	
	public static function mayAddTag(Module_Links $module, $user)
	{
		if (is_object($user)) {
			return GWF_Links::mayUserAddTag($module, $user);
		}
		else {
			return GWF_Links::mayGuestAddTag($module);
		}
	}
}
?>