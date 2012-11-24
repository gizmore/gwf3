<?php # :krashed__!~dig@mx.renome.ua QUIT :Excess Flood
if (false !== ($user = Dog::setupUser()))
{
	Dog::getServer()->removeUser($user);
}
else
{
	Dog_Log::error('Cannot get use from quit');
	Dog_Log::error(Dog::getMessage());
}
?>
