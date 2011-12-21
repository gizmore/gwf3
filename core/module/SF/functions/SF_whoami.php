<?php

final class SF_whoami extends SF_Function
{
	public function execute()
	{
		return GWF_User::getStaticOrGuest()->displayUsername();
	}
}
