<?php
function Upgrade_Slaytags_1_01(Module_Slaytags $module)
{
	GWF_Website::addDefaultOutput(GWF_HTML::message('Slaytags', "BPM and Key"));
	$songs = GDO::table('Slay_Song');
	$songs->createColumn('ss_bpm');
	$songs->createColumn('ss_key');
}
