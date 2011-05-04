<?php
function module_News_unread(array $args)
{
	$user = array_shift($args); $user instanceof GWF_User;
	$pattern = count($args) ? array_shift($args) : '[%s]';
}
?>