<?php
final class Slaytags_Main extends GWF_Method
{
	public function execute()
	{
		require GWF_CORE_PATH.'module/Slaytags/Slay_PNow.php';
		return $this->templateMain();
	}
	
	private function templateMain()
	{

		$left = Slay_PNow::getTimeLeft();
		
		$now = Slay_PNow::getNowPlaying($this->module);
// 		var_dump($left);
		
		GWF_Website::addJavascriptOnload("slayInitRedirect(".(max($left+2, 5)).");");
		
		$tVars = array(
			'href_history' => $this->module->getMethodURL('History', '&page='.Slay_PlayHistory::getNumPages()),
			'history' => Slay_PlayHistory::getLastPlayed(1),
			'now' => $now,
			'left' => $left,
//			'next' => Slay_Pnext::getNextPlaying(),
		);
		
		return $this->module->template('main.tpl', $tVars);
	}
}
?>