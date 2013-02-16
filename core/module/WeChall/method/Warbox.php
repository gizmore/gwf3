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
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_WarToken');
		$this->module->includeClass('sites/warbox/WCSite_WARBOX');
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
		$ip = gethostbyname(Common::getHostname($host));
		$port = Module_WeChall::instance()->cfgWarboxPort();
		$tVars = array(
			'epoch' => $this->getEpochUser(),
			'warboxes' => $this->getWarboxes(true),
			'token' => $token,
			'port' => $port,
			'host' => $host,
			'netcat_cmd' => sprintf('(echo -e "%s\n%s"; cat) | nc %s %s', $user->displayUsername(), $token, $ip, $port),
		);
		return $this->module->templatePHP('wartoken.php', $tVars);
	}
	
	private function getEpochUser()
	{
		return GWF_User::getByName('epoch_qwert');
	}
	
	private function getWarboxes($all=false)
	{
		$table = GDO::table('WC_Warbox');
		
		$joins = array('sites');
		$orderby = 'site_name ASC, wb_name ASC';
		if (!$all)
		{
			$where = 'site_status IN ("up","down")';
		}
		else
		{
			$where = '';
		}
		return $table->selectAll('*', $where, $orderby, $joins, -1, -1, GDO::ARRAY_O);
// 		$table = GDO::table('WC_Site');
// 		$back = array();
// 		$where = 'site_options&'.WC_Site::IS_WARBOX;
// 		$where .= $all ? '' : ' AND site_status IN ("up","down")';
// 		if (false === ($result = $table->selectColumn('site_id', $where)))
// 		{
// 			return $back;
// 		}
// 		foreach ($result as $siteid)
// 		{
// 			if (false !== ($site = WC_Site::getByID_Class($siteid)))
// 			{
// 				$back[] = $site;
// 			}
// 		}
// 		return $back;
	}
	
	private function genConfig()
	{
		$vars = array(
			'site_id',
			'site_name',
			'site_classname',
			'wb_id',
			'wb_name',
			'wb_levels',
			'wb_port',
			'wb_host',
			'wb_user',
			'wb_pass',
			'wb_weburl',
			'wb_ip',
			'wb_whitelist',
			'wb_blacklist',
			'wb_launched_at',
		);
		$output = GWF_Array::toCSV($vars)."\n";
		foreach ($this->getWarboxes(true) as $warbox)
		{
			$warbox instanceof WC_Warbox;
			$data = array();
			foreach ($vars as $var)
			{
				$data[] = $warbox->getVar($var);
			}
			$output .= GWF_Array::toCSV($data)."\n";
		}
			
// 		$format = '%5s, %15s, %5s, %2s, %64s, %24s, %s'."\n";
// 		$output = vsprintf('#'.$format, explode(',', 'CLS,IP,prt,RS,warhost,displayname,webhost'));
// 		foreach ($this->getWarboxes(true) as $warbox)
// 		{
			
// 			$warbox instanceof WC_Warbox;
// 			$output .= sprintf(' '.$format,
// 				$warbox->getVar('site_classname'), $warbox->getWarIP(),
// 				$warbox->getWarPort(), $warbox->getWarReduceScore(),
// 				$warbox->getWarHost(), $warbox->getSitename(), $warbox->getURL())."\n";
// 		}
		$_GET['ajax'] = 1;
		GWF_Website::plaintext();
		return $output;
	}
}
?>
