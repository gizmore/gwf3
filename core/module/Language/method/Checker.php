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
	private $enMissingFile= array();
	private $transMissing= array();
	private $enEmptyFile= array();
	private $errWarnMessage= '';

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
			'form' => $form->templateY($this->_module->lang('ft_checker')),
		);
		return $this->_module->templatePHP('checker.php', $tVars);
	}

	private function getForm()
	{
		$data = array(
			'langs' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'langs', Common::getPost('langs', 'en'), true), $this->_module->lang('th_langs')),
			'warns' => array(GWF_Form::CHECKBOX, true, $this->_module->lang('th_warns')),
			'check' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_check')),
		);
		return new GWF_Form($this, $data);
	}

	public function validate_langs($m, $arg) { return false; }

	private function onCheck()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->_module)))
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
		$this->onCheckRecursive(GWF_CORE_PATH.'lang');
		$this->onCheckRecursive(GWF_CORE_PATH.'module');
		$message = '';
		if ($this->errors > 0 || $this->warnings > 0 || $this->missing > 0)
		{
			$message .= $this->_module->message('dh_langchecker', $this->_module->lang('err_probsum', array($this->lang->getVar('lang_name'), $this->errors, $this->warnings, $this->missing)), false); # FIXME
		}
		if (count($this->enMissingFile) > 0)
		{
			$message .= $this->_module->error('dh_filemiss', array(count($this->enMissingFile), $this->enMissingFile), false);
		}
		if (count($this->enEmptyFile) > 0)
		{
			$message .= $this->_module->error('dh_emptyfile', array(count($this->enEmptyFile), $this->enEmptyFile), false);
		}
		if (count($this->transMissing) > 0)
		{
			$message .= $this->_module->error('dh_transfilemiss', array(count($this->transMissing), $this->transMissing), false);
		}
		if ($this->errWarnMessage !== '')
		{
			$message .= $this->errWarnMessage;
		}
		if ($message === '')
		{
			return $this->_module->message('err_noerror', array($this->lang->getVar('lang_name')), false);
		}
		return $message;

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

		if (!file_exists($path1) || !is_file($path1) || !is_readable($path1))
		{
			$this->enMissingFile[] = $this->_module->lang('err_filemiss', array($path1));
			$this->errors++;
			return;
		}
		else 
		{
			include $path1;
			if (!isset($lang))
			{
				$this->enEmptyFile[] = $this->_module->lang('err_emptyfile', array($path1));
				$this->errors++;
				return;
			}
			$lang1 = $lang;
			unset($lang);
		}

		$path2 = $this->getOtherPath($path1);
		if (!file_exists($path2) || !is_file($path2) || !is_readable($path2))
		{
			$this->transMissing[] = $this->_module->lang('err_transfilemiss', array($path2));
			$this->missing++;
			$lang2 = false;
		}
		elseif ($path1 === $path2) 
		{
			$lang2 = false;
		}
		else 
		{
			include $path2;
			$lang2 = $lang;
			unset($lang);
		}

		$errs = array();
		$warn = array();

		foreach ($lang1 as $key => $value)
		{
			if ($key === '')
			{
				$errs[] = $this->_module->lang('err_emptykey', array(GWF_Language::getByISO('en')->getVar('lang_name'), $path1));
				continue;
			}

			if ($lang2 === false)
			{
				continue;
			}

			if (!isset($lang2[$key]))
			{
				$errs[] = $this->_module->lang('err_keymiss', array($key));
			}
			elseif ($lang2[$key] === $lang1[$key])
			{
				$out = is_array($lang2[$key]) ? 'A('.GWF_Array::implodeHuman($lang2[$key]).')' : $lang2[$key];
				$warn[] = $this->_module->lang('err_transkey', array($key, htmlspecialchars($out)));
			}
		}

		if (is_array($lang2))
		{
			foreach ($lang2 as $key => $value)
			{
				if ($key === '') 
				{
					$errs[] = $this->_module->lang('err_emptykey', array($this->lang->getVar('lang_name'), $path2));
				}
			}
		}

		$this->errors += count($errs);
		$this->warnings += count($warn);

		if (count($errs) > 0)
		{
			$this->errWarnMessage .= $this->_module->error('dh_errors', array($path2, $errs), false);
		}
		if (count($warn) > 0 && $this->show_warns === true)
		{
			$this->errWarnMessage .= $this->_module->error('dh_warning', array($path2, $warn), false);
		}
	}
}
?>