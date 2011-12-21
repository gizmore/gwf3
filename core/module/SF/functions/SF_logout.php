<?php

final class SF_logout extends SF_Function
{
	public function execute()
	{
		$this->redirect('logout');
	}
}
