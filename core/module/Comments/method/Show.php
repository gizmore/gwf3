<?php
final class Comments_Show extends GWF_Method
{
	private $comments;
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		
		return $this->templateShow();
	}
	
	public function sanitize(Module_Comments $module, $check_enabled=true)
	{
		if ('' === ($cmts_id = Common::getGetString('cmts_id')))
		{
			return $this->_module->error('err_comments');
		}
		
		if (false === ($c = GWF_Comments::getByID($cmts_id)))
		{
			return $this->_module->error('err_comments');
		}

		if ($check_enabled)
		{
			if (!$c->isEnabled())
			{
				return $this->_module->error('err_disabled');
			}
		}
		
		$this->comments = $c;
		
		return false;
	}
	
	public function templateShow(Module_Comments $module, $href=NULL)
	{
		$nItems = $this->comments->getVar('cmts_count');
		$nPages = GWF_PageMenu::getPagecount($this->_module->cfgIPP(), $nItems);
		$page = Common::clamp(Common::getGetInt('cpage', 1), 1, $nPages);
		
		$cid = $this->comments->getID();
		$visible = GWF_Comment::VISIBLE;
		$comments = GDO::table('GWF_Comment')->selectObjects('*', "cmt_cid={$cid} AND cmt_options&{$visible}", 'cmt_date ASC');
		
		$tVars = array(
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $href),
			'comments' => $this->comments->displayComments($comments, $href),
		);
		return $this->_module->template('show.tpl', $tVars);
	}
}
?>