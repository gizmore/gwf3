<?php
/**
 *
 */
final class Language_Checker extends GWF_Method
{
	private $lang;
	private $show_warns = true;
	private $num_files = 0;
	private $warnings = 0;
	private $errors = 0;
	private $missing = 0;
	private $enMissingFile = array(); # missing english files
	private $transMissing = array(); # missing translated files
	private $enEmptyFile = array(); # files without $lang
	private $errWarnMessages = array(); # warnings
	private $errErrorMessages = array(); # errors

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
		# TODO: add WWW-module path?
		# check language files
		$this->onCheckRecursive(GWF_CORE_PATH.'lang');
		$this->onCheckRecursive(GWF_CORE_PATH.'module');

		$message = '';
		if ($this->errors > 0 || $this->warnings > 0 || $this->missing > 0)
		{
			# statistics
			$message .= $this->module->message('err_probsum', array($this->lang->getVar('lang_name'), $this->errors, $this->warnings, $this->missing), false);
		}
		if (count($this->enMissingFile) > 0)
		{
			# missing english files
			$message .= $this->module->error('err_missing_en_files', array(count($this->enMissingFile), implode('<br>'.PHP_EOL, $this->enMissingFile)), false);
		}
		if (count($this->enEmptyFile) > 0)
		{
			# empty and uncorrect files
			$message .= $this->module->error('err_empty_files', array(count($this->enEmptyFile), implode('<br>'.PHP_EOL, $this->enEmptyFile)), false);
		}
		if (count($this->transMissing) > 0)
		{
			# missing translation files
			$message .= $this->module->error('err_missing_files', array(count($this->transMissing), implode('<br>'.PHP_EOL, $this->transMissing)), false);
		}
		foreach($this->errErrorMessages as $path => $err)
		{
			$message .= $this->module->error('err_file_errors', array($path, implode('<br>'.PHP_EOL, $err)), false);
		}
		if (true === $this->show_warns)
		{
			foreach($this->errWarnMessages as $path => $warn)
			{
				$message .= $this->module->error('err_file_warnings', array($path, implode('<br>'.PHP_EOL, $warn)), false);
			}
		}

		if ($message === '')
		{
			return $this->module->message('no_errors', array($this->lang->getVar('lang_name')), false);
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
				$this->onCheckRecursive($fullpath);
			}
			elseif (Common::endsWith($entry, '_en.php')) # FIXME: replace en by GWF_DEFAULT_LANGUAGE?
			{
				$this->onCheckFile($fullisopath);
			}
			# ELSEIF!!
			elseif (false && is_file($fullisopath))
			{
				$this->onCheckFile($fullisopath);
			}

		}
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
			$this->enMissingFile[] = $path1;
			$this->errors++;
		}
		# Include english language file
		else 
		{
			# TODO: try{} to catch syntax errors?!
			include $path1;
			if (!isset($lang))
			{
				$this->enEmptyFile[] = $path1;
				$this->errors++;
				return;
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
			$this->transMissing[] = $path2;
			$this->missing++;
			$lang2 = false;
		}
		# include other-ISO file
		else 
		{
			include $path2;
			if (!isset($lang))
			{
				$this->enEmptyFile[] = $path2;
				$this->errors++;
				return;
			}
			$lang2 = $lang;
			unset($lang);
		}

		$errs = array();
		$warn = array();

		# English lang file
		foreach ($lang1 as $key => $value)
		{
			# Value is empty?
			if ($value === '')
			{
				$errs[] = $this->module->lang('err_empty_key', array('English', $key));
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
				$errs[] = $this->module->lang('err_missing_key', array($key));
			}
			# Key is translated?
			elseif ($lang2[$key] === $lang1[$key])
			{
				$out = is_array($lang2[$key]) ? 'A('.GWF_Array::implodeHuman($lang2[$key]).')' : $lang2[$key];
				$warn[] = $this->module->lang('err_key_not_translated', array($key, htmlspecialchars($out)));
			}
		}

		if (isset($lang1['']))
		{
			$errs[] = $this->module->lang('err_not_finished', array($this->lang->getVar('lang_name'), $path1));
		}

		if (is_array($lang2))
		{
			if (isset($lang2['']))
			{
				$errs[] = $this->module->lang('err_not_finished', array($this->lang->getVar('lang_name'), $path2));
			}
			# TODO: remove, do it faster
			# other-ISO lang file
			foreach ($lang2 as $key => $value)
			{
				if ($value === '')
				{
					$errs[] = $this->module->lang('err_empty_key', array($this->lang->getVar('lang_name'), $key)); # FIXME: lang name could be wrong
				}
			}
		}

		$this->errors += count($errs);
		$this->warnings += count($warn);

		$path = GWF_Debug::shortpath(realpath($path2)); # FIXME: duplication errors if two different modulelang locations

		if (count($errs) > 0)
		{
			$this->errErrorMessages[$path] = $errs;
		}
		if (count($warn) > 0 && $this->show_warns === true)
		{
			$this->errWarnMessages[$path] = $warn;
		}
	}
}
?>
