<?php
if (false !== ($channel = Dog::getChannel()))
{
	foreach ($channel->getUsers() as $user)
	{
		$user instanceof Dog_User;
		
		echo $user->displayName().': '.$channel->getPriv($user).PHP_EOL;
	}
}
?>