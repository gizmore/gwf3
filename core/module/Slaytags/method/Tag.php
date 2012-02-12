<?php
final class Slaytags_Tag extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		if (false === ($song = Slay_Song::getByID(Common::getGetString('stid'))))
		{
			return $this->module->error('err_song');
		}
		
		if (isset($_POST['doit']))
		{
			return $this->onTag($song).$this->templateTag($song);
		}
		
		return $this->templateTag($song);
	}
	
	private function templateTag(Slay_Song $song)
	{
		$user = GWF_Session::getUser();
		$has_tagged = Slay_TagVote::hasVoted($song, $user);
		$may_add_tag = Slay_Tag::mayAddTag($user);
		$form = $this->formTag($song);
		$tVars = array(
			'song' => $song,
			'has_tagged' => $has_tagged,
			'form' => $form->templateY($this->module->lang('ft_tag')),
// 			'form' => $this->getTinyFormTag($song),
			'href_add_tag' => $this->module->getMethodURL('AddTag', '&stid='.$song->getID()),
		);
		return $this->module->template('tag.tpl', $tVars);
	}
	
// 	private function getTinyFormTag(Slay_Song $song)
// 	{
		
// 	}
	
	private function formTagOLD(Slay_Song $song)
	{
		$data = array();
		
		$user = GWF_Session::getUser();
		$votes = Slay_TagVote::getVotes($song, $user);
		
		foreach (Slay_Tag::getTagNames() as $tag)
		{
			$checked = in_array($tag, $votes, true);
			$data["tag_$tag"] = array(GWF_Form::CHECKBOX, $checked, $this->module->lang('tag', array($tag, $song->getVotePercent($tag))));
		}
		
		$data['doit'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_tag'));
		
		return new GWF_Form($this, $data);
	}
	
	private function formTag(Slay_Song $song)
	{
		$data = array();
	
		$user = GWF_Session::getUser();
		$votes = Slay_TagVote::getVotes($song, $user);
	
		$html = '<div class="tinytagger">';
		foreach (Slay_Tag::getTagNames() as $tag)
		{
			$checked = in_array($tag, $votes, true) ? ' checked="checked"' : '';
// 			$data["tag_$tag"] = array(GWF_Form::CHECKBOX, $checked, $this->module->lang('tag', array($tag, $song->getVotePercent($tag))));
			
			$html .= sprintf('<input type="checkbox" name="tag_%s"%s /><span>%s</span>', $tag, $checked, $this->module->lang('tag', array($tag, $song->getVotePercent($tag))));
		}
		$html .= '</div>'.PHP_EOL;
	
		$data['html'] = array(GWF_Form::HTML, $html);
		$data['doit'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_tag'));
	
		return new GWF_Form($this, $data);
	}
	
	private function onTag(Slay_Song $song)
	{
		$form = $this->formTag($song);
		if (false !== ($error = $form->validateCSRF_WeakS()))
		{
			return $error;
		}
		
		$tags = array();
		$errors = array();
		
		foreach ($_POST as $k => $v)
		{
			if (Common::startsWith($k, 'tag_'))
			{
				$k = substr($k, 4);
				if (Slay_Tag::getByName($k) === false)
				{
					$errors[] = $this->module->lang('err_tag_uk');
				}
				else
				{
					$tags[] = $k;
				}
			}
		}
		
		if (count($errors) > 0)
		{
			return GWF_HTML::error('Slaytags', $errors);
		}
		
		$user = GWF_Session::getUser();
		
		if (false === Slay_TagVote::clearVotes($song, $user))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === Slay_TagVote::addVotes($song, $user, $tags))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $song->computeTags())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_tagged');
	}
}
?>