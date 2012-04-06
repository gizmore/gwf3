<?php
final class Language_EditFiles extends GWF_Method
{
	private $files = array();
	
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		if (false !== ($filename = Common::getGetString('filename', false)))
		{
			return $this->templateFile($filename);
		}
		
		if (false !== Common::getPost('save_file'))
		{
			return $this->onSaveFile();
		}
		
		return $this->templateFiles();
	}
	
	/**
	 * Gather the files, recursively
	 * @return unknown_type
	 */
	private function gatherFiles()
	{
		return $this->gatherFilesRec('.');
	}

	private function gatherFile($fullpath)
	{
		if ( !is_file($fullpath) || !is_readable($fullpath) )
		{
			return false;
		}
		
		if (1 !== preg_match('/_([a-z]{2})\.php/', $fullpath, $matches))
		{
			return false;
		}
		
		$iso = $matches[1];
		return array($fullpath, $this->isBranched($fullpath), GWF_LangFile::getByPath($fullpath, true), $iso, basename($fullpath));
	}
	
	
	private function gatherFilesRec($path)
	{
		if (false === ($dir = dir($path)))
		{
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $path));
			return false;
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
				$this->gatherFilesRec($fullpath);
			}
			elseif (1===preg_match('/_([a-z]{2})\.php$/D', $entry, $matches))
			{
				$iso = $matches[1];
				$this->files[] = array($fullpath, $this->isBranched($fullpath), GWF_LangFile::getByPath($fullpath), $iso, $entry);
			}
			else
			{
//				echo "SKIP ".$fullpath;
			}
		}
		
		return true;
	}
	
	private function isBranched($fullpath)
	{
		$filename = basename($fullpath);
		return is_file($fullpath.'../'.$filename);
	}
	
	private function templateFiles()
	{
		$this->gatherFiles();
		
		$tVars = array(
			'files' => $this->files,
			'href_checker' => $this->module->getMethodURL('Checker'),
			'href_bundle' => $this->module->getMethodURL('Bundle'),
		);
		return $this->module->templatePHP('files.php', $tVars);
	}

	private function templateFile($filename)
	{
		if (false === ($file = $this->gatherFile($filename)))
		{
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array(GWF_HTML::display($filename)));
		}
		
		$fileclass = GWF_LangFile::getByPath($file[0]);
		$form = $this->getFileForm($file);
		
		$tVars = array(
			'file' => $file,
			'class' => $fileclass,
			'form' => $form->templateY($this->module->lang('ft_edit_file', array(GWF_HTML::display($filename)))),
		);
		return $this->module->templatePHP('file.php', $tVars);
	}

	private function getFileForm(array $file)
	{
		$class = $file[2];
		$data = array();
		$data['text'] = array(GWF_Form::MESSAGE, $class->getVar('lf_data'), $this->module->lang('th_lf_data'));
		$data['cmds'] = array(GWF_Form::SUBMITS, array('check_syntax'=>$this->module->lang('btn_chksyn'),'save_file'=>$this->module->lang('btn_edit') ) );
		return new GWF_Form($this, $data);
	}
}
?>