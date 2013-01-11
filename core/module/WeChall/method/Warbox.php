<?php
/**
 * Handle Linking and Scoring for a Warbox. This is a challenge site like ROOTTHISBOX, which has 15 shell accounts but no official users.
 * Generates, shows and checks. warbox-tokens
 * @author epoch_qwert
 */
final class WeChall_Warbox extends GWF_Method
{
	public function execute()
	{
		$this->module->includeClass('WC_WarToken');
		
		# CHECK TOKEN
		if (isset($_GET['CHECK']))
		{
			$_GET['ajax'] = 1;
			if (false === ($username = Common::getGetString('username', false)))
			{
				return GWF_HTML::err('ERR_PARAMETER', array('username'));
			}
			if (false === ($token = Common::getGetString('token', false)))
			{
				return GWF_HTML::err('ERR_PARAMETER', array('token'));
			}
			return WC_WarToken::isValidWarToken($username, $token) ? '1' : '0';
		}
		
		# GET CONFIG
		if (isset($_GET['CONFIG']))
		{
			return $this->genConfig();
		}
		
		if (!GWF_Session::isLoggedIn())
		{
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
			
		# GEN AND SHOW
		return $this->templateToken();
	}
	
	public function getHTAccess()
	{
		return 'RewriteRule ^warboxes/?$ /index.php?mo=WeChall&me=Warbox'.PHP_EOL;
	}
	
	private function templateToken()
	{
		$user = GWF_Session::getUser();
		$token = WC_WarToken::genWarToken($user->getID());
		$host = Module_WeChall::instance()->cfgWarboxURL();
		$port = Module_WeChall::instance()->cfgWarboxPort();
		$tVars = array(
			'epoch' => $this->getEpochUser(),
			'warboxes' => $this->getWarboxes(),
			'token' => $token,
			'port' => $port,
			'netcat_cmd' => sprintf('echo -e "%s\n%s" | nc %s %s', $user->displayUsername(), $token, $host, $port),
		);
		return $this->module->templatePHP('wartoken.php', $tVars);
	}
	
	private function getEpochUser()
	{
		return GWF_User::getByName('epoch_qwert');
	}
	
	private function getWarboxes()
	{
		$table = GDO::table('WC_Site');
		$back = array();
		if (false === ($result = $table->selectColumn('site_id', 'site_status IN ("up","down")')))
		{
			return $back;
		}
		foreach ($result as $siteid)
		{
			if (false !== ($site = WC_Site::getByID_Class($siteid)))
			{
				if ($site->isWarBox())
				{
					$back[] = $site;
				}
			}
		}
		return $back;
	}
	
	private function genConfig()
	{
		#          CLS, IP,          ,prt,RS, boxhostname,  dispname, website
		$output = 'WCW0,176.58.89.195,113,1,w0.warchall.net,Warchall0,http://www.warchall.net'."\n";
		foreach ($this->getWarboxes() as $warbox)
		{
			$warbox instanceof WC_Site;
			$output .= sprintf('%s,%s,%s,%s,%s,%s,%s',
				$warbox->getVar('site_classname'), $warbox->getIP(),
				$warbox->getPort(), $warbox->getReduceScore(),
				$warbox->getHostname(), $warbox->getSitename(), $warbox->getURL())."\n";
		}
		$_GET['ajax'] = 1;
		GWF_Website::plaintext();
		return $output;
	}
}
?>
