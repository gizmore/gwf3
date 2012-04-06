<?php
/**
 *
 */
final class Language_Checker extends GWF_Method
{
	private $lang;
	private $show_warns = true;
	private $num_files = 0;
	private $warnings = array('en' => 0, 'tr' => 0);
	private $errors = array('en' => 0, 'tr' => 0);
	private $missing = array('en' => 0, 'tr' => 0);
	private $MissingFile = array('en' => array(), 'tr' => array()); # missing files (base, translation)
	private $EmptyFile = array('en' => array(), 'tr' => array()); # files without $lang (base, translation)
	private $errWarnMessages = array(); # warnings
	private $errErrorMessages = array(); # errors
	private $dirsToSkip = array(
			'1' => 'core/module/Lamb/lamb_module/Shadowlamb/lang/cmds',
			'2' => 'core/module/Lamb/lamb_module/Shadowlamb/lang/commands',
			); # array of directories to skip

	public function getUserGroups() { return 'admin'; }
	
	public function execute()
	{
		if (false !== Common::getPost('check'))
		{
			return $this->onCheck();
		}
		return $this->templateChecker();
	}

	private function templateChecker()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_checker')),
		);
		return $this->module->templatePHP('checker.php', $tVars);
	}

	private function getForm()
	{
		$data = array(
			'langs' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'langs', Common::getPost('langs', 'en'), true), $this->module->lang('th_langs')),
			'warns' => array(GWF_Form::CHECKBOX, true, $this->module->lang('th_warns')),
			'check' => array(GWF_Form::SUBMIT, $this->module->lang('btn_check')),
		);
		return new GWF_Form($this, $data);
	}

	public function validate_langs($m, $arg) { return false; }

	private function onCheck()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->module)))
		{
			return $errors.$this->templateChecker();
		}

		if (false === ($this->lang = GWF_Language::getByID(Common::getPost('langs'))))
		{
			return GWF_HTML::err('ERR_UNKNOWN_LANGUAGE').$this->templateChecker();
		}

		$this->show_warns = isset($_POST['warns']);

		return $this->templateChecker().$this->onCheckB();
	}

	private function onCheckB()
	{
		# check language files, also challenges' ones
		$this->onCheckRecursive(GWF_CORE_PATH.'lang');
		$this->onCheckRecursive(GWF_CORE_PATH.'module');
		$this->onCheckRecursive(GWF_WWW_PATH.'challenge');
		# TODO: Add an option to hide english errors and show only errors in the translation files?
		$message = '';
		# statistics for english files
		if ($this->errors['en'] > 0 || $this->warnings['en'] > 0 || $this->missing['en'] > 0)
		{
			$message .= $this->message('th_summary', array('English'), 'err_probsum', array($this->errors['en'], $this->warnings['en'], $this->missing['en']), false);
		}
		else
		{
			$message .= $this->message('th_summary', array('English'), 'msg_no_errors', NULL, false); # FIXME: If GWF_DEFAULT_LANGUAGE is added, change this to use the default lang
		}
		# statistics for italian files
		if ($this->errors['tr'] > 0 || $this->warnings['tr'] > 0 || $this->missing['tr'] > 0)
		{
			$message .= $this->message('th_summary',  array($this->lang->getVar('lang_name')), 'err_probsum', array($this->errors['tr'], $this->warnings['tr'], $this->missing['tr']), false);
		}
		else
		{
			$message .= $this->message('th_summary',  array($this->lang->getVar('lang_name')), 'msg_no_errors', NULL, false);
		}
		# missing english files
		if (count($this->MissingFile['en']) > 0)
		{
			$message .= $this->error('err_missing_en_files', array(count($this->MissingFile['en'])), "err_body", array(implode('<br>'.PHP_EOL, $this->MissingFile['en'])), false);
		}
		# missing translation files
		if (count($this->MissingFile['tr']) > 0)
		{
			$message .= $this->error('err_missing_files', array(count($this->MissingFile['tr'])), "err_body", array(implode('<br>'.PHP_EOL, $this->MissingFile['tr'])), false);
		}
		# empty and uncorrect english files
		if (count($this->EmptyFile['en']) > 0)
		{
			$message .= $this->error('err_empty_files', array(count($this->EmptyFile['en'])), "err_body", array(implode('<br>'.PHP_EOL, $this->EmptyFile['en'])), false);
		}
		# empty and uncorrect translation files
		if (count($this->EmptyFile['tr']) > 0)
		{
			$message .= $this->error('err_empty_files', array(count($this->EmptyFile['tr'])), "err_body", array(implode('<br>'.PHP_EOL, $this->EmptyFile['tr'])), false);
		}
		foreach($this->errErrorMessages as $path => $err)
		{
			$message .= $this->error('err_file_errors', array($path), "err_body", array(implode('<br>'.PHP_EOL, $err)), false);
		}
		if (true === $this->show_warns)
		{
			foreach($this->errWarnMessages as $path => $warn)
			{
				$message .= $this->error('err_file_warnings', array($path), "err_body", array(implode('<br>'.PHP_EOL, $warn)), false);
			}
		}
		
		return GWF_Debug::shortpath($message);
	}

	private function onCheckRecursive($path)
	{
		if (false === ($dir = dir($path)))
		{
			return;
		}

		while (false !== ($entry = $dir->read()))
		{
			if (Common::startsWith($entry, '.'))
			{
				continue;
			}

			$fullpath = $path.'/'.$entry;
			$fullisopath = $path.'/'.substr($entry, 0, -7).sprintf('_%s.php', $this->lang->getISO());

			if (is_dir($fullpath))
			{
				if($entry === 'lang')
				{
					$this->locateBaseFile($fullpath);
				}
				if(in_array(GWF_Debug::shortpath(realpath($fullpath)), $this->dirsToSkip))
				{
					continue;
				}
				$this->onCheckRecursive($fullpath);
			}
			elseif (Common::endsWith($entry, '_en.php')) # FIXME: replace en by GWF_DEFAULT_LANGUAGE?
			{
				$this->onCheckFile($fullisopath);
			}

		}
	}
	
	# If you find a lang directory, call this method on it to see if it contains the english file: 
	# if it doesn't, insert the path into the english missing files
	private function locateBaseFile($path)
	{
		$dir = dir($path);		
		
		while (false !== ($entry = $dir->read()))
		{
			if(Common::endsWith($entry, '_en.php')) # FIXME: as above, replace en with GWF_DEFAULT_LANGUAGE?
			{
				return;
			}
		}
		$this->MissingFile['en'][] = $path;
		$this->missing['en']++;
	}

	private function getOtherPath($path)
	{
		return substr($path, 0, -7).'_en.php';
	}

	/**
	 * Check a file for translation errors 
	 * @todo remove 2 loops, compare keys with array sort
	 */
	private function onCheckFile($path2)
	{
		$this->num_files++;

		$path1 = $this->getOtherPath($path2);
		# English file exists?
		if (!file_exists($path1) || !is_file($path1) || !is_readable($path1))
		{
			$this->MissingFile['en'][] = $path1;
			$this->errors['en']++;
			$lang1 = false;
		}
		# Include english language file
		else 
		{
			# TODO: try{} to catch syntax errors?!
			include $path1;
			if (!isset($lang) || empty($lang))
			{
				$this->EmptyFile['en'][] = $path1;
				$this->errors['en']++;
				$lang = false;
			}
			$lang1 = $lang;
			unset($lang);
		}

		# same paths?
		if ($path1 === $path2) 
		{
			$lang2 = false;
		}
		# other-ISO file exists?
		elseif (!file_exists($path2) || !is_file($path2) || !is_readable($path2))
		{
			# if $lang1 is false or empty, the error lies within the english file, not the translation one
			if(false !== $lang1 && !empty($lang1))
			{
				$this->MissingFile['tr'][] = $path2;
				$this->missing['tr']++;				
			}
			$lang2 = false;
		}
		# include other-ISO file
		else 
		{
			include $path2;
			if (!isset($lang))
			{
				$this->EmptyFile['tr'][] = $path2;
				$this->errors['tr']++;
				$lang = false;
			}
			$lang2 = $lang;
			unset($lang);
		}
		
		# separation between errors/warns related to english files and errors in tranaltion files
		$errs = array('en' => array(), 'tr' => array());
		$warn = array('en' => array(), 'tr' => array());
		
		# Check if there really is a lang to check
		if (is_array($lang1))
		{
			# English lang file
			foreach ($lang1 as $key => $value)
			{
				# Value is empty?
				if ($value === '')
				{
					$errs['en'][] = $this->module->lang('err_empty_key', array($key));
					continue;
				}
	
				# other ISO lang file
				if ($lang2 === false)
				{
					continue;
				}
	
				# Key exists?
				if (false === isset($lang2[$key]))
				{
					$errs['tr'][] = $this->module->lang('err_missing_key', array($key));
				}
				# Key is translated?
				elseif ($lang2[$key] === $lang1[$key])
				{
					$out = is_array($lang2[$key]) ? 'A('.GWF_Array::implodeHuman($lang2[$key]).')' : $lang2[$key];
					$warn['tr'][] = $this->module->lang('err_key_not_translated', array($key, htmlspecialchars($out)));
				}
			}
			if (isset($lang1['']))
			{
				$errs['en'][] = $this->module->lang('err_not_finished', array($path1));
			}
		}
		
		# Check if there really is a lang to check
		if (is_array($lang2))
		{
			if (isset($lang2['']))
			{
				$errs['tr'][] = $this->module->lang('err_not_finished', array($path2));
			}
			# TODO: remove, do it faster
			# other-ISO lang file
			foreach ($lang2 as $key => $value)
			{
				if ($value === '')
				{
					$errs['tr'][] = $this->module->lang('err_empty_key', array($key));
				}
			}
		}
		
		if($lang2 !== false)
		{
			$this->errors['tr'] += count($errs['tr']);
			$this->warnings['tr'] += count($warn['tr']);
			$path = GWF_Debug::shortpath(realpath($path2)); # FIXME: duplication errors if two different modulelang locations
			
			if (count($errs['tr']) > 0)
			{
				$this->errErrorMessages[$path] = $errs['tr'];
			}
			if (count($warn['tr']) > 0 && $this->show_warns === true)
			{
				$this->errWarnMessages[$path] = $warn['tr'];
			}
		}
		
		if($lang1 !== false)
		{
			$this->errors['en'] += count($errs['en']);
			$this->warnings['en'] += count($warn['en']);
			$path = GWF_Debug::shortpath(realpath($path1)); # FIXME: duplication errors if two different modulelang locations
			
			if (count($errs['en']) > 0)
			{
				$this->errErrorMessages[$path] = $errs['en'];
			}
			if (count($warn['en']) > 0 && $this->show_warns === true)
			{
				$this->errWarnMessages[$path] = $warn['en'];
			}
		}
	}
	
	public function error($title, $targs=NULL, $key, $kargs=NULL, $log=true) {
		return GWF_HTML::error($this->module->lang($title, $targs), $this->module->lang($key, $kargs), $log);
	}
	public function message($title, $targs=NULL, $key, $kargs=NULL, $log=true) {
		return GWF_HTML::message($this->module->lang($title, $targs), $this->module->lang($key, $kargs), $log);
	}
}
?>
