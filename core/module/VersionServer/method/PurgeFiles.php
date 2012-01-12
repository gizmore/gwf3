<?php

final class VersionServer_PurgeFiles extends GWF_Method
{
	public function execute()
	{
		if (false !== Common::getPost('purge')) {
			return $this->onPurge($this->_module);
		}
		return $this->templatePurge($this->_module);
	}
	
	private function formPurge()
	{
		$data = array(
			'purge' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_purge')),
		);
		return new GWF_Form($this, $data);
	}

	private function templatePurge()
	{
		$form = $this->formPurge($this->_module);
		$tVars = array(
			'form' => $form->templateX($this->_module->lang('ft_purge')),
		);
		return $this->_module->template('purge.tpl', $tVars);
	}

	private function onPurge()
	{
		$form = $this->formPurge($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templatePurge($this->_module);
		}
		
		$table = GDO::table('GWF_VersionFiles');
		if (false === $table->truncate()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		GWF_VersionFiles::populateAll();
		
		return $this->_module->message('msg_purged', array($table->countRows(), GWF_Upload::humanFilesize(GWF_VersionFiles::getSizeUnpacked())));
	}
	
}

?>
