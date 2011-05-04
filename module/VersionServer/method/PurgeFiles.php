<?php

final class VersionServer_PurgeFiles extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('purge')) {
			return $this->onPurge($module);
		}
		return $this->templatePurge($module);
	}
	
	private function formPurge(Module_VersionServer $module)
	{
		$data = array(
			'purge' => array(GWF_Form::SUBMIT, $module->lang('btn_purge')),
		);
		return new GWF_Form($this, $data);
	}

	private function templatePurge(Module_VersionServer $module)
	{
		$form = $this->formPurge($module);
		$tVars = array(
			'form' => $form->templateX($module->lang('ft_purge')),
		);
		return $module->templatePHP('purge.php', $tVars);
	}

	private function onPurge(Module_VersionServer $module)
	{
		$form = $this->formPurge($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templatePurge($module);
		}
		
		$table = GDO::table('GWF_VersionFiles');
		if (false === $table->truncate()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		GWF_VersionFiles::populateAll();
		
		return $module->message('msg_purged', array($table->countRows(), GWF_Upload::humanFilesize(GWF_VersionFiles::getSizeUnpacked())));
	}
	
}

?>
