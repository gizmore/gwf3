<?php
require 'config.php';
require 'header.php';
?>
<h1>Ranking</h1>
<?php
$ipp = 50;
$table = GDO::table('DLDC_User');
$nItems = $table->countRows();
$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
$by = $table->getWhitelistedBy(Common::getGetString('by'), 'level');
$dir = GDO::getWhitelistedDirS(Common::getGetString('dir'), 'DESC');
$from = GWF_PageMenu::getFrom($page, $ipp);
$headers = array(
	array('Lvl', 'level', 'DESC'),
	array('Username', 'username', 'ASC'),
	array('Firstname', 'firstname', 'ASC'),
	array('Lastname', 'lastname', 'ASC'),
	array('Regdate', 'regdate', 'DESC'),
);
$pagemenu = GWF_PageMenu::display($page, $nPages, "?page=%PAGE%&by=$by&dir=$dir");
echo $pagemenu;
echo GWF_Table::start('ranking_table');
echo GWF_Table::displayHeaders1($headers, "?page=1&by=%BY%&dir=%DIR%");
$result = $table->select('*', '', "$by $dir", null, $ipp, $from);
while ($user = $table->fetch($result, GDO::ARRAY_O))
{
	$user instanceof DLDC_User;
	echo GWF_Table::rowStart();
	echo GWF_Table::column($user->getVar('level'), 'gwf_num');
	echo GWF_Table::column($user->display('username'));
	echo GWF_Table::column($user->display('firstname'));
	echo GWF_Table::column($user->display('lastname'));
	echo GWF_Table::column($user->displayRegdate(), 'gwf_date');
	echo GWF_Table::rowEnd();
} 
echo GWF_Table::end();
echo $pagemenu;
?>
<?php
require 'footer.php';
