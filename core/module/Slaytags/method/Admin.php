<?php
final class Slaytags_Admin extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute()
	{
		if (isset($_POST['recalc']))
		{
			$this->onRecalcTags().$this->templateAdmin();
		}
		
		return $this->templateAdmin();
	}
	
	private function templateAdmin()
	{
		$form_actions = $this->formActions();
		$tVars = array(
			'form_actions' => $form_actions->templateY('Actions'),
		);
		return $this->_module->template('admin.tpl', $tVars);
	}
	
	private function formActions()
	{
		$data = array(
			'recalc' => array(GWF_Form::SUBMIT, 'RecalcTags'),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onRecalcTags()
	{
		$form_actions = $this->formActions();
		if (false !== ($error = $form_actions->validate($this->_module)))
		{
			return $error;
		}
		
		$table = GDO::table('Slay_Song');
		if (false === ($result = $table->select('*', '', 'ss_id ASC', NULL)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		while (false !== ($song = $table->fetch($result, GDO::ARRAY_O)))
		{
			$song instanceof Slay_Song;
			if (false === $song->computeTags())
			{
				die('OOOOOOPS!!!!!!');
			}
		}
		
		$table->free($result);
		
		return $this->_module->message('rehashed!');
	}
}
?>