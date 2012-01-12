<?php
/**
 * Un/Subscribe whole boards.
 * @author gizmore
 * @since GWF3.1
 */
final class Forum_SubscribeBoard extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		if (false !== ($bid = Common::getGetInt('subscribe', false)))
		{
			return $this->onSubscribe($this->_module, $bid);
		}
		elseif (false !== ($bid = Common::getGetInt('unsubscribe', false)))
		{
			return $this->onUnSubscribe($this->_module, $bid);
		}
		else
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
	}
	
	private $board;
	
	private function sanitize(Module_Forum $module, $boardid)
	{
		if (false === ($this->board = GWF_ForumBoard::getBoard($boardid)))
		{
			return $this->_module->error('err_board');
		}
		
		if (!$this->board->hasPermissionS())
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		return false;
	}
	
	private function onSubscribe(Module_Forum $module, $boardid)
	{
		if (false !== ($error = $this->sanitize($this->_module, $boardid)))
		{
			return $error;
		}
		
		$userid = GWF_Session::getUserID();
		if (false === GWF_ForumSubscrBoard::subscribe($userid, $boardid))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$href = htmlspecialchars($this->board->getShowBoardHREF());
		return $this->_module->message('msg_subscrboard', array($href));
	}

	private function onUnSubscribe(Module_Forum $module, $boardid)
	{
		if (false !== ($error = $this->sanitize($this->_module, $boardid)))
		{
			return $error;
		}
		
		$userid = GWF_Session::getUserID();
		if (false === GWF_ForumSubscrBoard::unsubscribe($userid, $boardid))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$href = htmlspecialchars($this->_module->getMethodURL('Subscriptions'));
		return $this->_module->message('msg_unsubscrboard', array($href));
	}
}
?>