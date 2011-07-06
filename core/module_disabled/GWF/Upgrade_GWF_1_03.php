<?php
function Upgrade_GWF_1_03(Module_GWF $module)
{
	GWF_HTML::message('GWF', '[+] GWF 1.03 (faster session handling)', true, true);
	GDO::table('GWF_Session')->createTable(true);
}
?>