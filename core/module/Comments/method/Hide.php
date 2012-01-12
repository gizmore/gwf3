<?php
final class Comments_Hide extends GWF_Method
{
	public function execute()
	{
		if (false === ($comment = GWF_Comment::getByID(Common::getGetString('cmt_id'))))
		{
			return $this->_module->error('err_comment');
		}

		if (false === ($comments = $comment->getComments()))
		{
			return $this->_module->error('err_comments');
		}
		
		if (!$comments->canModerate(GWF_Session::getUser()))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false === $comment->onVisible(false))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_hide');
	}
}
?>
