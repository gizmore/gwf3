<?php

final class Chat_AjaxStream extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^gwf_chat.php$ module/Chat/gwf_chat.php'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->stream($module);
	}
	
	private function stream(Module_Chat $module)
	{
		set_time_limit(0);
		$t = time();
		$times = array($t,$t,$t,$t);
//		$msgtable = new GWF_ChatMsg(false);
		$channel = '';
		
		while (true)
		{
			GWF_ChatOnline::setSessOnline($module);
//			GWF_Session::updateLastActivity();
			
			$page = $module->getAjaxUpdates($times);
			# --- Anything happened?
			if ($page !== '')
			{
				GWF_Javascript::newSection();
				echo $page;
				GWF_Javascript::endSection();
			}

			usleep(999950);
		}
	}
}

?>