<?php
/**
 * Moderate the comments.
 * Permission is granted via hashcodes, so we can moderate without beeing logged in.
 * @author gizmore
 * @version 3.0
 * @since 3.0
 */
final class Comments_Moderate extends GWF_Method
{
	private $comment;
	
	public function execute()
	{
		if (false !== ($cmt_id = Common::getGetString('show', false)))
		{
			return $this->onShow($cmt_id);
		}
		
		if (false !== ($cmt_id = Common::getGetString('delete', false)))
		{
			return $this->onDelete($cmt_id);
		}
		
		return GWF_HTML::err('ERR_PARAMETER', array());
	}
	
	private function sanitize($cmt_id)
	{
		if (false === ($c = GWF_Comment::getByID($cmt_id)))
		{
			return $this->_module->error('err_comment');
		}
		
		if (Common::getGetString('ctoken', '') !== $c->getHashcode())
		{
			return $this->_module->error('err_hashcode');
		}
		
		$this->comment = $c;
		
		return false;
	}
	
	private function onShow($cmt_id)
	{
		if (false !== ($error = $this->sanitize($cmt_id)))
		{
			return $error;
		}
		
		if (false === $this->comment->onVisible(true))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_visible');
	}

	private function onDelete($cmt_id)
	{
		if (false !== ($error = $this->sanitize($cmt_id)))
		{
			return $error;
		}
		
		if (false === $this->comment->onDelete())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_deleted');
	}
}
?>