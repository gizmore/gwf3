<?php
class DOGMOD_Register extends DOGMOD_GWF
{
	public function trigger_register(Dog_User $user)
	{
		return $this->executeGWFMethod();
	}
	
	
}