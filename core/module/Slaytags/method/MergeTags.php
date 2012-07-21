<?php
final class Slaytags_MergeTags extends GWF_Method
{
	/**
	 * @var Slay_Tag
	 */
	private $tag = false;
	/**
	 * @var Slay_Tag
	 */
	private $tag2 = false;
	
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute()
	{
		$this->module->includeClass('Slay_TagSelect');
		$back = '';
		
		if (isset($_POST['merge_tags']))
		{
			$back = $this->onMergeTags();
		}
		return $back.$this->templateMergeTags();
	}
	
	private function formMergeTags()
	{
		$data = array(
			'tag_old' => array(GWF_Form::SELECT, Slay_TagSelect::singleSelect('tag_old'), $this->module->lang('th_tag_old')),
			'tag_new' => array(GWF_Form::SELECT, Slay_TagSelect::singleSelect('tag_new'), $this->module->lang('th_tag_new')),
			'merge_tags' => array(GWF_Form::SUBMIT, $this->module->lang('btn_merge_tags')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateMergeTags()
	{
		$form = $this->formMergeTags();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_merge_tags')),
		);
		return $this->module->template('merge_tags.tpl', $tVars);
	}
	
	private function onMergeTags()
	{
		$form = $this->formMergeTags();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		$oldid = $this->tag->getID();
		$newid = $this->tag2->getID();
		
		set_time_limit(0);
		
		$tags = GDO::table('Slay_Tag');
		$songs = GDO::table('Slay_Song');
		$tag_votes = GDO::table('Slay_TagVote');
		
		if (false === ($result = $songs->select('*')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		while (false !== ($song = $songs->fetch($result, GDO::ARRAY_O)))
		{
			$song instanceof Slay_Song;
			$sid = $song->getID();
			
// 			printf('CHECK SONG %d<br/>', $sid);
			
			$users_vote_for_old = $tag_votes->selectColumn('stv_uid', "stv_sid=$sid AND stv_tid=$oldid");
			$users_vote_for_new = $tag_votes->selectColumn('stv_uid', "stv_sid=$sid AND stv_tid=$newid");
			$users_vote_new_add = array();
			
			# for all we want to merge into
			foreach ($users_vote_for_old as $uid)
			{
				# if not yet exist
				if (!in_array($uid, $users_vote_for_new))
				{
					$users_vote_new_add[] = $uid;
				}
			}
			
			foreach ($users_vote_new_add as $uid)
			{
				$tag_votes->insertAssoc(array(
					'stv_uid' => $uid,
					'stv_sid' => $sid,
					'stv_tid' => $newid,
					'stv_date' => GWF_Time::getDate(),
				));
			}
			
			$tag_votes->deleteWhere("stv_tid=$oldid");
			
			$tags->deleteWhere("st_id=$oldid");
			
			$song->computeTags();
		}
		
	}
	
	public function validate_tag_old($m, $arg)
	{
		if (false === ($this->tag = Slay_Tag::getByID($arg)))
		{
			return $m->lang('err_unknown_tag');
		}
		
		return false;
	} 

	public function validate_tag_new($m, $arg)
	{
		if (false === ($this->tag2 = Slay_Tag::getByID($arg)))
		{
			return $m->lang('err_unknown_target_tag');
		}
		
		if (!$this->tag)
		{
			return false;
		}
		
		if ($this->tag->getID() === $this->tag2->getID())
		{
			return $m->lang('err_merge_same_tag');
		}
		return false;
	}
}
?>
