<?php
include '../lib/Session.php';
include '../secret.php';
chdir('../../../');
require 'protected/config.php';
require_once '../gwf3.class.php';
$gwf = new GWF3('../', array(
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

$user = GWF_User::getStaticOrGuest();

GWF_Debug::setMailOnError(false);

Session::init('temper', GWF_DOMAIN, 60*60*24*7);

if (!Session::instance())
{
    $err = 'Please refresh the page to get a real cookie.';
}
elseif (@$_POST['login'])
{
    if (@$_POST['password'] === 'user' and @$_POST['username'] === 'user')
    {
        Session::set('username', 'user');
        Session::set('lastpage', 'login');
        Session::set('language', 'en');
        Session::set('lock_ip', (!!@$_POST['lock_ip']) ? $_SERVER['REMOTE_ADDR'] : false);
        $msg = 'Welcome back, ' . Session::get('username') . '!';
    }
    else
    {
        $err = 'Username / Password does not exist.';
    }
}
elseif (@$_POST['logout'])
{
    Session::reset();
}

Session::set('lastpage', 'login');
Session::set('requests', Session::get('requests', 0) + 1);
Session::commit();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Temper</title>
    <link rel="stylesheet" href="site.css" />
  </head>
  <body>
  
    <?php require 'nav.php'; ?>

    <main>
     <form method="post">
      <table>
        <tbody>
          <tr>
            <td>Username:</td>
            <td><input type="text" name="username" value="<?=$user->displayUsername()?>" /></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="password" name="password" value="" /></td>
          </tr>
          <tr>
            <td>Lock to IP:</td>
            <td><input type="checkbox" name="lock_ip" checked="checked" /></td>
          </tr>
          <tr>
            <td><input type="submit" name="login" value="Login!" /></td>
            <td><input type="submit" name="logout" value="Logout!" /></td>
          </tr>
        </tbody>
      </table>
     </form>
    </main>
    
  </body>
</html>
