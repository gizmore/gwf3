<?php
final class Slaytags_Admin extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute()
	{
		set_time_limit(0);
		
		if (isset($_POST['recalc']))
		{
			return $this->onRecalcTags().$this->templateAdmin();
		}
		
		if (isset($_POST['cleanup_ut']))
		{
			return $this->onCleanupUntagged().$this->templateAdmin();
		}
		
		return $this->templateAdmin();
	}
	
	private function templateAdmin()
	{
		$form_actions = $this->formActions();
		$tVars = array(
			'form_actions' => $form_actions->templateY($this->module->lang('th_actions')),
		);
		return $this->module->template('admin.tpl', $tVars);
	}
	
	private function formActions()
	{
		$data = array(
			'recalc' => array(GWF_Form::SUBMIT, $this->module->lang('btn_recalc_tags')),
			'cleanup_ut' => array(GWF_Form::SUBMIT, $this->module->lang('btn_cleanup_ut')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onRecalcTags()
	{
		$form_actions = $this->formActions();
		if (false !== ($error = $form_actions->validate($this->module)))
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
		
		return $this->module->message('rehashed!');
	}

	private function onCleanupUntagged()
	{
		$songs = GDO::table('Slay_Song');
		
		$cut = GWF_Time::getDate(14, time()-3600);
		
		$songs->deleteWhere("ss_taggers=0 AND ss_last_played<'$cut'");
		
		return $this->module->message('msg_cleanup');
	}
}
?>