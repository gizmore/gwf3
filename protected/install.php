<html>
<body>
<?php
chdir('../');

if (!is_readable('protected/config.php')) {
	die('Try protected/install_wizard.php');
}

require_once 'gwf3.class.php'; 
GWF3::onLoadConfig(GWF_CONFIG_PATH);
GWF_Language::initEnglish();
GWF_HTML::init();
GWF_Log::init(false, true, 'protected/logs');

//GWF_HTML::init();
require_once 'protected/install_scripts/install_functions.php';

if (false !== Common::getPost('core')) {
	install_core(false);
}
if (false !== Common::getPost('lang')) {
	install_createLanguage(true, true, false);
}
if (false !== Common::getPost('lang2')) {
	install_createLanguage(true, true, true);
}
if (false !== Common::getPost('mods')) {
	install_all_modules();
}
if (false !== Common::getPost('users')) {
	install_default_users();
}
if (false !== Common::getPost('gwf23')) {
	require_once 'protected/install_upgrade/install23.php';
}

?>
<div>
<form action="install.php" method="post">
	<div><input type="submit" name="core" value="Core Tables" /></div>
	<div><input type="submit" name="lang" value="Lang+Country" /></div>
	<div><input type="submit" name="lang2" value="Lang+Country+IP" /></div>
	<div><input type="submit" name="mods" value="All Modules" /></div>
	<div><input type="submit" name="users" value="Admin Account" /></div>
	<div><input type="submit" name="gwf23" value="GWF2=>3" /></div>
</form>
</div>

</body>
</html>