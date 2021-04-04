<?php
include '../lib/Session.php';
include '../secret.php';
chdir('../../../');
require 'protected/config.php';
require_once '../gwf3.class.php';
$gwf = new GWF3('./', array(
    'init' => true, # Init?
    'bootstrap' => false, # Init GWF_Bootstrap?
    'website_init' => true, # Init GWF_Website?
    'autoload_modules' => true, # Load modules with autoload flag?
    'load_module' => false, # Load the requested module?
    'load_config' => false, # Load the config file? (DEPRECATED) # TODO: REMOVE
    'start_debug' => true, # Init GWF_Debug?
    'get_user' => true, # Put user into smarty templates?
    'do_logging' => true, # Init the logger?
    'log_request' => true, # Log the request?
    'blocking' => !defined('GWF_SESSION_NOT_BLOCKING'),
    'no_session' => false, # Suppress session creation?
    'store_last_url' => true, # Save the current URL into session?
    'ignore_user_abort' => true, # Ignore abort and continue the script on browser kill?
));

GWF_Debug::setMailOnError(false);

$user = GWF_User::getStaticOrGuest();
define('GWF_PAGE_TITLE', 'Temper');

if (false === ($wechall = GWF_Module::loadModuleDB('WeChall', true, true)))
{
    die('GWF3/WC5 not installed?');
}
$wechall->includeClass('WC_Challenge');

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 6, 'challenge/temper/index.php', false);
}

Session::init('temper', GWF_DOMAIN, 60*60*24*7);
Session::set('lastpage', 'content');

if (!Session::instance())
{
    $err = 'Please login prior to access content.';
}
elseif (Session::get('username') === 'System')
{
    ob_start();
    GWF_Module::loadModuleDB('Forum', true);
    $chall->onChallengeSolved($user->getID());
    $content = ob_get_contents();
    ob_end_clean();
}
else
{
    $err = 'Content is restricted!';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Temper Content</title>
    <link rel="stylesheet" href="site.css" />
  </head>
  <body>
    <?php require 'nav.php';?>
    
    <?php if (Session::get('username', 'Guest') === 'System') : ?>
    <div>Super Secret Content!!!</div>
    <div><?=$content?></div>
    <?php endif; ?>
    
  </body>
</html>
