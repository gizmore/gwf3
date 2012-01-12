<?php
final class Konzert_Intro extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^startseite.html$ index.php?mo=Konzert&me=Intro'.PHP_EOL;
	}
	
	public function execute()
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/color.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jq/ghostwriter.js');
		GWF_Website::addJavascriptOnload('initGhostwriter();');
		GWF_Website::setPageTitle($this->_module->lang('page_title'));
		
		$this->_module->setNextHREF(GWF_WEB_ROOT.'melanie_gobbo.html');
		
		return $this->templateIntro();
	}
	
	private function templateIntro()
	{
//		$intro = GWF_Session::getOrDefault('konz_intro', true);
//		GWF_Session::set('konz_intro', false);
		$tVars = array(
//			'playmusic' => $intro,
		);
		return $this->_module->template('intro.tpl', $tVars);
	}
}
?>