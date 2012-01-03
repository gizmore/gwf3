<?php
final class Slaytags_Main extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		require GWF_CORE_PATH.'module/Slaytags/Slay_PNow.php';
		return $this->templateMain($module);
	}
	
	private function templateMain(Module_Slaytags $module)
	{
		$left = Slay_PNow::getTimeLeft();
		
		GWF_Website::addJavascriptOnload("slayInitRedirect(".($left+1).");");
		
		$tVars = array(
			'href_history' => $module->getMethodURL('History', '&page='.Slay_PlayHistory::getNumPages()),
			'history' => Slay_PlayHistory::getLastPlayed(1),
			'now' => Slay_PNow::getNowPlaying($module),
			'left' => $left,
//			'next' => Slay_Pnext::getNextPlaying(),
		);
		
		return $module->template('main.tpl', $tVars);
	}
}
?>