<?php
$bh = Dog::getChannelByArg('##blackhats');
if ($bh)
{
	$bh->sendPRIVMSG('.isup www.wechall.net');
}
