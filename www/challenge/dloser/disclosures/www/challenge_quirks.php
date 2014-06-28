<?php
### No MySQL Wizards :)
$db1->setVerbose(false);
$db2->setVerbose(false);

### Not relevant. This keeps db clean ###
function dldc_cleanup()
{
	$table = GDO::table('DLDC_User');
	$table->deleteWhere("wechall_userid=".GWF_Session::getUserID());
	if ($table->affectedRows() > 0)
	{
		echo GWF_HTML::message('Disclosures', 'We have deleted your old account for this challenge!', false);
	}
}
