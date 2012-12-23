<?php
final class Dog_Shadowclient extends GWF_Method
{
	public function execute()
	{
		$user = GWF_User::getStaticOrGuest();
		
		GWF_Website::addJavascriptInline($this->getInlineJS($user));
		
		$tVars = array(
			'worlds' => $this->getWorlds($user),
// 			'dog' => 'Dog',
// 			'lang' => GWF_Language::getCurrentISO(),
			
		);
		
		GWF3::setDesign('jqmsl4');
		return $this->module->template('shadowclient.tpl', $tVars);
	}
	
	private function getWorlds(GWF_User $user)
	{
		return array(
			array('url' => 'ws://'.Common::getHost().':31337', 'name' => '#shadowlamb', 'descr' => ' - This is the Test server which is running since ages.'),
		);
	}
	
	private function getInlineJS(GWF_User $user)
	{
		return sprintf("var sl4_botname = 'Dog'; var sl4_langiso = 'en';");
	}
}
?>
