<?php
/**
 * Set Users on your Ignore List.
 * @author gizmore
 * @version 1.0
 */
final class PM_Ignore extends GWF_Method
{
	# Needs Login
	public function isLoginRequired() { return true; }
	
	# Some HTAccess
	public function getHTAccess()
	{
		return
			'RewriteRule ^pm/(do|do_not)/ignore/(\d+)/? index.php?mo=PM&me=Ignore&mode=$1&uid=$2'.PHP_EOL.
			'RewriteRule ^pm/ignores/by/([^/]+)/([ADESC,]+)/page-(\d+)$ index.php?mo=PM&me=Ignore&by=$1&dir=$2&page=$3'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($mode = Common::getGet('mode'))) {
			return $this->onIgnore($mode, Common::getGetString('uid'), Common::getGetString('reason')).$this->templateIgnore();
		}
		
		return $this->templateIgnore();
	}
	
	private function templateIgnore()
	{
		return $this->module->requestMethodB('Overview');
	}

	public function onIgnore($mode, $ignore_id, $reason='')
	{
		if (false === ($user = GWF_User::getByID($ignore_id))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		$uid = GWF_Session::getUserID();
		
		if ($uid === $user->getID()) {
			return $this->module->error('err_ignore_self');
		}

		switch($mode)
		{
			case 'do':
				if ($user->isInGroupName(GWF_Group::ADMIN)) {
					return $this->module->error('err_ignore_admin');
				}
				if (false === GWF_PMIgnore::ignore($uid, $user->getID(), $reason)) {
					return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
				}
				break;
			case 'do_not':
				if (false === GWF_PMIgnore::unignore($uid, $user->getID())) {
					return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
				}
				break;
			default: return GWF_HTML::err('ERR_PARAMETER', array( __FILE__, __LINE__, 'mode'));
		}
		
		$msgkey = $mode === 'do' ? 'msg_ignored' : 'msg_unignored';
		return $this->module->message($msgkey, array($user->display('user_name')));
	}
}
?>