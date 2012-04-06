<?php
final class Language_Bundle extends GWF_Method
{
	/**
	 * @var GWF_Language
	 */
	private $target = false;
	
	private $missing_bits = array();
	
	public function execute()
	{
		error_reporting(0);
		if (false !== Common::getPost('bundle')) {
			return $this->onBundle().$this->templateBundle();
		}
		elseif (false !== Common::getPost('missing')) {
			return $this->onCreateMissing().$this->templateBundle();
		}
		
		return $this->templateBundle();
	}
	
	private function templateBundle()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_bundle')),
		);
		return $this->module->templatePHP('bundle.php', $tVars);
	}

	private function getForm()
	{
		$data = array(
			'target' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'target', Common::getPost('target')), $this->module->lang('th_target')),
			'all_targets' => array(GWF_Form::CHECKBOX, false, $this->module->lang('th_all_targets')),
			'missing' => array(GWF_Form::SUBMIT, $this->module->lang('btn_missing')),
			'bundle' => array(GWF_Form::SUBMIT, $this->module->lang('btn_bundle')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getLanguageFiles($iso)
	{
		$files = array();
		$this->getLanguageFilesR($iso, 'challenge', $files);
		$this->getLanguageFilesR($iso, 'lang', $files);
		$this->getLanguageFilesR($iso, 'modules', $files);
		return $files;
	}
	
	private function getLanguageFilesR($iso, $path, array &$files)
	{
		if (false === ($dir = dir($path))) {
			return;
		}
		
		while (false !== ($entry = $dir->read()))
		{
			$fullpath = $path.'/'.$entry;
			if (Common::startsWith($entry, '.')) {
			}
			elseif (is_dir($fullpath)) {
				$this->getLanguageFilesR($iso, $fullpath, $files);
			}
			elseif (preg_match("/.+_$iso.php$/D", $entry)) {
				$files[] = $fullpath;
			}
		}
		
		$dir->close();
	}
	
	public function validate_target(Module_Language $m, $arg)
	{
		if (isset($_POST['all_targets'])) {
			return false;
		}
		
		if (false === ($this->target = GWF_Language::getByID($arg))) {
			return GWF_HTML::lang('ERR_UNKNOWN_LANGUAGE');
		}
		
		return false;
	}
	
	private function getTargets()
	{
		if (isset($_POST['all_targets'])) {
			return explode(';', GWF_SUPPORTED_LANGS);
		}
		return array($this->target->getISO());
	}
	
	private function getAllISO()
	{
		if (isset($_POST['all_targets'])) {
			return 'all';
		}
		return $this->target->getISO();
	}

	/**
	 * Get Archive Name. We either have missing or bundle packages.
	 * $type is missing or bundle
	 * @return unknown_type
	 */
	private function getArchiveName($type)
	{
		$iso = $this->getAllISO();
		return sprintf('protected/zipped/language_%s_%s.zip', $type, $iso);
	}
	
	###############
	### Missing ###
	###############
	private function onCreateMissing()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors;
		}
		
		# No ZIP?
		if (!class_exists('ZipArchive', false)) {
			return $this->module->error('err_no_zip');
		}

		# Create ZIP?
		$archive = new GWF_ZipArchive();
		$archivename = $this->getArchiveName('missing');
		if (false === ($archive->open($archivename, ZipArchive::CREATE))) {
			return $this->module->error('err_zip', __FILE__, __LINE__);
		}
		
		$files = $this->getLanguageFiles('en');
		$targets = $this->getTargets();
		
		foreach ($targets as $target)
		{
//			var_dump($target);
			$this->missing_bits = array();
			
			foreach ($files as $file)
			{
//				var_dump($file);
				
				$otherfile = $this->getLangFilename($file, $target);
				if (!file_exists($otherfile))
				{
//					var_dump($otherfile);
					$archive->addFile($file, $otherfile);
				}
				
				elseif ($otherfile !== $file)
				{
					$this->missingBits($file, $otherfile);
				}
			}
			
			$this->exportMissingBits($archive, $target);
		}
		
		if (false === $archive->close()) {
			return $this->module->error('err_zip', __FILE__, __LINE__);
		}
		
		return $this->module->message('msg_bundled', array($archivename, $archive->getTotalFilesCounter()));
	}
	
	private function getLangFilename($filename, $iso)
	{
		return preg_replace('/^(.*_)([a-z]{2})\.php$/', '$1'.$iso.'.php', $filename);
	}
	
	####################
	### Missing Bits ###
	####################
	private function missingBits($file, $otherfile)
	{
		include $file;
		$lang_en = $lang;
		
		include $otherfile;
		$lang2 = $lang;
		
		foreach ($lang_en as $key => $value)
		{
			if (is_array($value)) {
				$valueE2 = GWF_Array::implode('[,]', $value);
			} else {
				$valueE2 = $value;
			}
			
			if (isset($lang2[$key])) {
				$valueO = $lang2[$key];
				if (is_array($valueO)) {
					$valueO = GWF_Array::implode('[,]', $valueO);
				}
			}
			else {
				$valueO = $valueE2;
			}
			
			if ($valueO === $valueE2) {
				$this->addMissingBit($file, $key, $value);
			}
		}
	}
	
	private function addMissingBit($file, $key, $value)
	{
		if (!isset($this->missing_bits[$file])) {
			$this->missing_bits[$file] = array();
		}
		$this->missing_bits[$file][$key] = $value;
	}
	
	private function exportMissingBits(GWF_ZipArchive $archive, $target)
	{
		$contents = '';
		$filename = 'missing_bits_'.$target.'.php';
		
		foreach ($this->missing_bits as $filename2 => $data)
		{
			$contents .= $this->exportMissingBitsB($filename2, $data);
		}
		
		$archive->addFromString($filename, $contents);
		
//		file_put_contents('/tmp/'.$filename, $contents);
//		$archive->addFile('/tmp/'.$filename, $filename);
//		unlink('/tmp/'.$filename);
	}
	
	private function exportMissingBitsB($filename, array $data)
	{
		$t = "\t";
		$back = '########'.PHP_EOL;
		$back .= '### '.$filename.PHP_EOL;
		$back .= '########'.PHP_EOL.PHP_EOL;
		
		foreach ($data as $key => $value)
		{
			if (is_array($value))
			{
				$back .= $t."'$key' => array( ".PHP_EOL;
				foreach ($value as $k => $v)
				{
					$v = addcslashes($v, "'");
					$back .= $t.$t."'$k' => '$v'".PHP_EOL;
				}
				$back .= $t.'),'.PHP_EOL;
			}
			else
			{
				$value = addcslashes($value, "'");
				$back .= $t.sprintf('\'%s\' => \'%s\',', $key, $value).PHP_EOL;
			}
		}
		
		return $back;
	}
	
	##############
	### Bundle ###
	##############
	private function onBundle()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors;
		}
		# No ZIP?
		if (!class_exists('ZipArchive', false)) {
			return $this->module->error('err_no_zip');
		}
		
		$back = '';
		$targets = $this->getTargets();
		foreach ($targets as $target)
		{
			$back .= $this->onBundleTarget($target);
		}
		return $back;
	}
	
	private function onBundleTarget($target)
	{
		# Create ZIP
		$archive = new GWF_ZipArchive();
		$archivename = sprintf('protected/zipped/language_bundle_%s.zip', $target);
		if (false === ($archive->open($archivename, ZipArchive::CREATE))) {
			return $this->module->error('err_zip', __FILE__, __LINE__);
		}
		
		$files = $this->getLanguageFiles($target);
		foreach ($files as $file)
		{
			$archive->addFile($file);
		}
		
		if (false === $archive->close()) {
			return $this->module->error('err_zip', __FILE__, __LINE__);
		}
		
		return $this->module->message('msg_bundled', array($archivename, $archive->getTotalFilesCounter()));
	}
	
}
?>