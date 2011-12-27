<?php

final class SF_login extends SF_Function
{
	public function getOptions()
	{
		return array(
//			'username',
//			'password',
		);
	}
	public function execute()
	{
		// TODO: CSFR, user/pass args
		$args = $this->parseArgs();
		if(isset($args['username']) && isset($args['password']))
		{
			return; // TODO
		}
		return $this->redirect('login');
	}
}
