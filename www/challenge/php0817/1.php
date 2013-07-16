<?php 
$username = GWF_User::getStaticOrGuest()->displayUsername();
echo sprintf('Hello %s, welcome to the forums page.', $username);
