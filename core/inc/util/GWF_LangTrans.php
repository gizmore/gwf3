<?php
final class GWF_LangTrans
{
	private $base_path = '';
	private $trans = array();
	
	public static function getBrowserISO()
	{
		return GWF_Language::getCurrentISO();
	}
	
	public function __construct($path)
	{
		$this->base_path = $path;
		$this->loadLanguage(self::getBrowserISO());
	}
	
//	private function implodeArgs(array &$args)
//	{
//		foreach ($args as $i => $arg)
//		{
//			if (is_array($arg))
//			{
//				unset($arg[$i]);
//				$args[] = $this->implodeArgs($args);
//			}
//		}
//		return $args;
//	}
	
	private function translate($iso, $key, $args=NULL)
	{
//		$args = $this->implodeArgs($args);
//		$key = array_shift($args);
		
		# Could get rid of this? :)
		if (!isset($this->trans[$iso][$key])) {
			return htmlspecialchars($key).(is_array($args) ? ': '.implode(',', $args) : '');
		}
		
		$back = $this->trans[$iso][$key];
		$back = $this->replaceArgs($back, $args);
		
		return $back;
	}
	private function replaceArgs($back, $args)
	{
		if (is_array($args))
		{
			$len = count($args);
			$i = 0;
			while ($i < $len)
			{
				$j = $i++;
				$back = str_replace("%$i%", $args[$j], $back);
			}
		}
		return $back;
	}
	
	public function lang($key, $args=NULL)
	{
		return $this->translate(self::getBrowserISO(), $key, $args);
	}
	public function langA($var, $key, $args=NULL) {
		$back = $this->lang($var);
		return (array_key_exists($key, $back) || !is_array($back) ) ? $this->replaceArgs($back[$key], $args) : $back;
	}
	
	public function langUser(GWF_User $user, $key, $args)
	{
//		$args = func_get_args();
//		array_shift($args);
		$iso1 = $user->getVar('user_langid');
		if (false !== $this->loadLanguage($iso1)) {
			return $this->translate($iso1, $key, $args);
		}
		$iso2 = $user->getVar('user_langid2');
		if (false !== $this->loadLanguage($iso2)) {
			return $this->translate($iso2, $key, $args);
		}
		return $this->translate(self::getBrowserISO(), $key, $args);
	}
	
	public function langISO($iso, $key, $args=NULL)
	{
		if (false === $this->loadLanguage($iso)) {
			return $this->translate(GWF_DEFAULT_LANG, $key, $args);
		}
		return $this->translate($iso, $key, $args);
	}
	
	public function langAdmin($key, $args=NULL)
	{
		if (false === $this->loadLanguage(GWF_LANG_ADMIN)) {
			return $this->translate(GWF_DEFAULT_LANG, $key, $args);
		}
		return $this->translate(GWF_LANG_ADMIN, $key, $args);
	}
	
	private function loadLanguage($iso)
	{
		if (isset($this->trans[$iso])) {
			return true;
		}
		
		$path1 = $this->base_path.'_'.$iso.'.php';
		if (Common::isFile($path1)) {
			$success = true;
			$path = $path1;
		}
		elseif (isset($this->trans[GWF_DEFAULT_LANG])) {
			$this->trans[$iso] = $this->trans[GWF_DEFAULT_LANG];
			return false;
		}
		else {
			$path = $this->base_path.'_'.GWF_DEFAULT_LANG.'.php';
			$success = false;
		}
		
		if (!Common::isFile($path)) {
			if (!Common::isFile(GWF_PATH.$path)) {
				die(sprintf('A language file is completely missing: %s', htmlspecialchars($path)));
			} else {
				$path = GWF_PATH.$path;
			}
		}
		
		require $path;
		$this->trans[$iso] = $lang;
		return $success;
	}
}
?>