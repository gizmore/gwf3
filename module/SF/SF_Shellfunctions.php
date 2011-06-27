<?php

final class SF_Shellfunctions
{

	public function redirectLogin($username, $password) {
		// Posible, gwf_csrf?
		
		return $this->login();
	}
	public static function redirectIntern($url) { header(sprintf('Location: http://%s', $_SERVER['SERVER_NAME'].GWF_WEB_ROOT.$url)); }
	
	public function lp() { return GWF_Website::addCSS('/templates/SF/css/print.css'); }
	public function lpr() { return $this->lp(); }
	public function md5(array $cmd) { 
		$cmd = implode(' ', $cmd);
		GWF_HTML::message('MD5-Sum', md5($cmd), false, true);
		return 'The md5Sum for '.htmlspecialchars($cmd).' is: '.md5($cmd); 
	}
	public function date() { return GWF_Time::displayDate(GWF_Time::getDate(14)); }
	public function login($cmd = array()) { 
		return count($cmd) >= 2 ? $this->redirectLogin($cmd[0], $cmd[1]) : self::redirectIntern('login'); 
		
	}
	public function useradd() { return self::redirectIntern('register'); }
	public function adduser() { return $this->useradd(); }
	public function logout() { return self::redirectIntern('logout'); }
	public function su() { return $this->login(); }
	public function whoami() { return GWF_User::getStaticOrGuest()->displayUsername(); }
	public function who() { 
		// module beat is really trash....
		if (false !== ($heart = GWF_Module::loadModuleDB('Heart'))) {
			return printf('<span id="gwf_heartbeat">%s</span>', $heart->execute('Beat'));
		} else return 'nobody';
	}
}