<?php
/**
 * Un/Subscribe whole boards.
 * @author gizmore
 * @since GWF3.1
 */
final class Forum_SubscribeBoard extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($bid = Common::getGetInt('subscribe', false)))
		{
			return $this->onSubscribe($module, $bid);
		}
		elseif (false !== ($bid = Common::getGetInt('unsubscribe', false)))
		{
			return $this->onUnSubscribe($module, $bid);
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
			return $module->error('err_board');
		}
		
		if (!$this->board->hasPermissionS())
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		return false;
	}
	
	private function onSubscribe(Module_Forum $module, $boardid)
	{
		if (false !== ($error = $this->sanitize($module, $boardid)))
		{
			return $error;
		}
		
		$userid = GWF_Session::getUserID();
		if (false === GWF_ForumSubscrBoard::subscribe($userid, $boardid))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$href = htmlspecialchars($this->board->getShowBoardHREF());
		return $module->message('msg_subscrboard', array($href));
	}

	private function onUnSubscribe(Module_Forum $module, $boardid)
	{
		if (false !== ($error = $this->sanitize($module, $boardid)))
		{
			return $error;
		}
		
		$userid = GWF_Session::getUserID();
		if (false === GWF_ForumSubscrBoard::unsubscribe($userid, $boardid))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$href = htmlspecialchars($module->getMethodURL('Subscriptions'));
		return $module->message('msg_unsubscrboard', array($href));
	}
}
?>