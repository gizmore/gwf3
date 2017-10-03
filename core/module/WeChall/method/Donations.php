<?php

final class WeChall_Donations extends GWF_Method
{
	public function getHTAccess()
	{
		return
		'RewriteRule ^donations/?$ index.php?mo=WeChall&me=Donations'.PHP_EOL;
	}
	
	public function execute()
	{
		GWF_Website::setPageTitle('Donations');
		
		return $this->templateDonations();
	}
	
	public function templateDonations()
	{
		$tVars = array(
			'paybutton' => $this->getPayButton(),
		);
		return $this->module->templatePHP('donations.php', $tVars);
	}
	
	private function getPayButton()
	{
		return <<<EOB
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="R9RXRQ3EAYU2G">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="donations">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
EOB;
	}
}
