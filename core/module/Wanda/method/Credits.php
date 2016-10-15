<?php
final class Wanda_Credits extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/credits/?$ index.php?mo=Wanda&me=Credits'.PHP_EOL;
	}
	
	public function execute()
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jsxm/xm.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jsxm/xmeffects.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jsxm/xmgfx.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'tpl/wanda/js/wanda_credits_text.js');
		GWF_Website::addJavascript(GWF_WEB_ROOT.'tpl/wanda/js/wanda_credits.js');
		GWF_Website::addCSS(GWF_WEB_ROOT.'tpl/wanda/css/credits.css');
		$tVars = array(
// 			'rand' => GWF_Random::rand(0, 65535),
// 			'scrollText' => $this->scrollText(),
// 			'width' => $this->gridWidth(),
// 			'height' => $this->gridHeight(),
		);
		return $this->module->templatePHP('credits.php', $tVars);
	}
	
	###############
	### private ###
	###############
	private function gridWidth()
	{
		return strpos($this->scrollText(), "\n");
	}
	
	private function gridHeight()
	{
		$w = $this->gridWidth() + 1;
		return (int)(mb_strlen($this->scrollText()) / $w);
	}

}


