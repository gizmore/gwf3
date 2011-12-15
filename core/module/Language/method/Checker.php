<?php
final class Language_Checker extends GWF_Method
{
	private $lang;
	private $show_warns = true;
	private $num_files = 0;
	private $warnings = 0;
	private $errors = 0;
	private $missing = 0;
	
	
	public function getUserGroups() { return 'admin'; }
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('check')) {
			return $this->onCheck($module);
		}
		return $this->templateChecker($module);
	}
	
	private function templateChecker(Module_Language $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_checker')),
		);
		return $module->templatePHP('checker.php', $tVars);
	}
	
	private function getForm(Module_Language $module)
	{
		$data = array(
			'langs' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'langs', Common::getPost('langs', 'en'), true), $module->lang('th_langs')),
			'warns' => array(GWF_Form::CHECKBOX, true, $module->lang('th_warns')),
			'check' => array(GWF_Form::SUBMIT, $module->lang('btn_check')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_langs(Module_Language $module, $arg) { return false; }
	
	private function onCheck(Module_Language $module)
	{
		$form = $this->getForm($module);
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->templateChecker($module);
		}
		
		if (false === ($this->lang = GWF_Language::getByID(Common::getPost('langs')))) {
			return GWF_HTML::err('ERR_UNKNOWN_LANGUAGE').$this->templateChecker($module);
		}
		
		$this->show_warns = isset($_POST['warns']);
		
		return $this->onCheckB($module).$this->templateChecker($module);
	}
	
	private function onCheckB(Module_Language $module)
	{
		$this->onCheckRecursive(GWF_CORE_PATH.'lang');
		$this->onCheckRecursive(GWF_CORE_PATH.'module');
		
		return GWF_HTML::message('LangChecker', sprintf('%s language files contain %d errors and %d warnings. %d files missing.', $module->getName(), $this->errors, $this->warnings, $this->missing), false);
	}

	private function onCheckRecursive($path)
	{
		if (false === ($dir = dir($path))) {
			return;
		}
		
		while (false !== ($entry = $dir->read()))
		{
			if (Common::startsWith($entry, '.')) {
				continue;
			}
			
			$fullpath = $path.'/'.$entry;
			
			if (is_dir($fullpath))
			{
				$this->onCheckRecursive($fullpath);
			}
			elseif (Common::endsWith($entry, '_en.php'))
			{
				$this->onCheckFile($fullpath);
			}
			
		}
	}
	
	private function getOtherPath($path)
	{
		return substr($path, 0, -7).sprintf('_%s.php', $this->lang->getISO());
	}
	
	private function onCheckFile($path1)
	{
		$this->num_files++;
//		var_dump($path1);
		
		if (!file_exists($path1) || !is_file($path1) || !is_readable($path1)) {
			echo GWF_HTML::error('LangChecker', 'Language file is missing: '.$path1, false);
			$this->errors++;
			return;
		}
		else {
			include $path1;
			if (!isset($lang))
			{
				echo GWF_HTML::error('LangChecker', 'Language file is empty: '.$path1, false);
				$this->errors++;
				return;
			}
			$lang1 = $lang;
			unset($lang);
		}
		
		$path2 = $this->getOtherPath($path1);
		if (!file_exists($path2) || !is_file($path2) || !is_readable($path2)) {
			echo GWF_HTML::error('LangChecker', 'Language file is missing: '.$path2, false);
			$this->missing++;
			$lang2 = false;
		}
		elseif ($path1 === $path2) {
			$lang2 = false;
		}
		else {		
			include $path2;
			$lang2 = $lang;
			unset($lang);
		}
		
		$errs = array();
		$warn = array();
		
		foreach ($lang1 as $key => $value)
		{
			if ($key === '') {
				$errs[] = sprintf('Language file contains empty key: %s', $path1);
				continue;
			}
			
			if ($lang2 === false) {
				continue;
			}
			
			if (!isset($lang2[$key])) {
				$errs[] = sprintf('Missing key %s', $key);
			}
			elseif ($lang2[$key] === $lang1[$key]) {
				$warn[] = sprintf('Key `%s` is not translated in %s: (%s)', $key, $path2, $lang2[$key]);
			}
		}
		
		if (is_array($lang2))
		{
			foreach ($lang2 as $key => $value)
			{
				if ($key === '') {
					$errs[] = sprintf('Language file contains empty key: %s', $path2);
				}
			}
		}
		
		$this->errors += count($errs);
		$this->warnings += count($warn);
		
		if ( (count($errs) > 0) || ( (count($warn) > 0) && $this->show_warns === true) )
		{
			echo GWF_HTML::error('LangChecker', sprintf('There are errors in %s', $path1), false);
		}
		
		if ($this->show_warns === true) {
			echo GWF_HTML::errorA('LangChecker', $warn, false);
		}
		echo GWF_HTML::errorA('LangChecker', $errs, false);
	}
}
?>
