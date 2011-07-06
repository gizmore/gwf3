<?php

$headers = array(
	array($tLang->lang('th_module_name')),
	array($tLang->lang('th_version_installed')),
	array($tLang->lang('th_version_on_disk')),
	array($tLang->lang('th_version_on_server')),
);

$headers = GWF_Table::getHeaders2($headers);

echo GWF_Table::start();
echo GWF_Table::displayHeaders($headers);
foreach($tVars['data'] as $data)
{
	echo GWF_Table::rowStart();
	echo GWF_Table::column($data[0]);
	echo GWF_Table::column($data[1]);
	echo GWF_Table::column($data[2]);
	echo GWF_Table::column($data[3]);
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

