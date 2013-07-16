<?php 
$username = GWF_User::getStaticOrGuest()->displayUsername();
echo sprintf('Hello %s, This is the guestbook.', $username);
