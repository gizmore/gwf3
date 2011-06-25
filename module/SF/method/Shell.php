<?php

/**
 * This is a imitated LinuxShell
 * TODO: Language
 * @author spaceone
 */
final class SF_Shell extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^Shell/(.*+)$ index.php?mo=SF&me=Shell&cmd=$1'.PHP_EOL;
	}
	public function execute(GWF_Module $module)
	{
		return $this->templateShell($module, $this->init(Common::getRequestString('cmd')), htmlspecialchars(Common::getRequestString('cmd')));
	}
	private static $cmds = array(
		'cat' => array('descr' => 'Quelltext anzeigen', 'args' => 1),
		'ls' => array('descr' => 'Ordnerinhalt auflisten', 'args' => 1),
		'cd' => array('descr' => 'Ordner wechseln', 'args' => 1),
		'cp' => array('descr' => '', 'args' => 1),
		'rm' => array('descr' => '', 'args' => 1),
		'mv' => array('descr' => '', 'args' => 1),
		'rm' => array('descr' => '', 'args' => 1),
		'ln' => array('descr' => 'Link zur Linkliste hinzufügen', 'args' => 1),
		'find' => array('descr' => 'Datei suchen', 'args' => 1),
		'locate' => array('descr' => 'Artikel suchen', 'args' => 1),
		'md5' => array('descr' => 'MD5 Summe eines Strings anzeigen', 'args' => 2),
		'lp' => array('descr' => 'Seite in Druckansicht anzeigen', 'args' => 1),
		'lpr' => array('descr' => 'Seite in Druckansicht anzeigen', 'args' => 1),
		'pwd' => array('descr' => 'aktuellen Verzeichnis&amp;Dateinamen anzeigen', 'args' => 1),
		'df' => array('descr' => 'Zeigt Speicherplatzinformationen des Servers an', 'args' => 1),
		'diff' => array('descr' => '', 'args' => 1),
		'free' => array('descr' => 'freien Arbeitsspeicher anzeigen', 'args' => 1),
		'passwd' => array('descr' => 'Passwort ändern', 'args' => 1),
		'alias' => array('descr' => 'Funktionen für SF_Shell vorschlagen', 'args' => 1),
		'userdel' => array('descr' => 'Benutzerkonto löschen', 'args' => 1),
		'useradd' => array('descr' => 'auf SF registrieren', 'args' => 1),
		'adduser' => array('descr' => 'auf SF registrieren', 'args' => 1),
		'w' => array('descr' => '', 'args' => 1),
		'whoami' => array('descr' => 'zeigt Benutzerinformationen an', 'args' => 1),
		'who' => array('descr' => 'zeigt eingeloggte Benutzer an', 'args' => 1),
		'id' => array('descr' => 'zeigt Gruppenzugehörigkeiten an', 'args' => 1),
		'uptime' => array('descr' => 'zeigt eingeloggte Zeit an', 'args' => 1),
		'echo' => array('descr' => 'gibt Text aus', 'args' => 1),
		'eval' => array('descr' => 'führt PHP-Befehle aus', 'args' => 1),
		'exec' => array('descr' => 'führt Shell-Befehle aus', 'args' => 1),
		'time' => array('descr' => 'zeigt aktuelle Uhrzeit an', 'args' => 1),
		'date' => array('descr' => 'zeigt Datumsinformationen an', 'args' => 1),
		'logout' => array('descr' => 'Ausloggen', 'args' => 1),
		'login' => array('descr' => 'Einloggen', 'args' => 1),
		'su' => array('descr' => 'Einloggen', 'args' => 1),
		'system' => array('descr' => 'führt Shell-Befehle aus', 'args' => 1),
		'exploit' => array('descr' => '', 'args' => 1),
//		'' => array('descr' => '', 'args' => 1),
//		'' => array('descr' => '', 'args' => 1),
//		'' => array('descr' => '', 'args' => 1),
//		'' => array('descr' => '', 'args' => 1),
//		'' => array('descr' => '', 'args' => 1),
	);
	
	private static $pipes = array(
		'more' => array(), # also do overflow:auto;
		'less' => array(), # also do overflow: scroll;
		'help' => array(),
	);
	
	public function init($cmdS) 
	{
		if($cmdS !== false && $cmdS != NULL)
		{
//			$this->onPipe($cmdS);
			
			$cmdS = trim($cmdS);
			$cmdS = explode(' ', $cmdS);
			$cmd = strtolower($cmdS[0]);
			# hilfe befehl?
			if($cmd === 'help') {
				return (count($cmdS) > 1) ? $this->onHelp($cmdS[1]) : $this->onHelp();
			}
			if($cmd === 'echo') {
				unset($cmdS[0]);
				return htmlspecialchars(implode(' ', $cmdS)); 
			}
			# existiert der befehl?
			if(array_key_exists($cmd, self::$cmds)) {
				# sind die mindestargumente angegeben?
				if(count($cmdS) >= self::$cmds[$cmd]['args']) {
					$shfuncts = new Shellfunctions;
					return method_exists($shfuncts, $cmd) ? $shfuncts->$cmd($cmdS) : $this->onFunctionError($cmd);
				} else {
					return $this->onArgs($cmd);
				}
			} else {
				return $this->onError($cmd);
			}
		} 
		# no command given!
		else {
			return (array($_GET['mo'], $_GET['me']) == array('SF', 'Shell') ) ? $this->onNoCommand() : '';
		}
	}
	public function onOptions() { return;}
	public function onPipe() { return; }
	public function onError($cmd = 'This') { return GWF_HTML::error(__CLASS__, $cmd.' isn\'t a command!'); }
	public function onFunctionError($cmd) { return GWF_HTML::error(__CLASS__, 'the '.  htmlspecialchars($cmd).' Function is currently not programmed ;) But I\'m on it!'); }
	public function onArgs($cmd) { return GWF_HTML::error(__CLASS__, 'You didn\'t give enough params!'); }
	public function onNoCommand() { return GWF_HTML::error(__CLASS__, 'You didn\'t give me any command!'); }
	public function onHelp($cmd = false) { 
		// help for all commands?
		if($cmd === false) {
			$ret = '<ul class="shell_output">'.PHP_EOL;
			foreach(self::$cmds as $key => $cmd) {
				$ret .= '<li>'.$key.': '.$cmd['descr'].'</li>'.PHP_EOL;
			}
			$ret .= '</ul>'.PHP_EOL;
			return $ret;
		} 
		// help for a single command
		else {
			return array_key_exists($cmd, self::$cmds) ? self::$cmds[$cmd]['descr'] : $this->onError($cmd);
		}
		
	}
	
	private function templateShell(Module_SF $module, $output, $lastCMD)
	{
		$module->onLoadLanguage();
		$tVars = array('output' => $output,'lastCMD' => $lastCMD, 'SF' => new SF, 'user' => GWF_User::getStaticOrGuest());
		return $module->template('shell.tpl', $tVars);
	}
	
}