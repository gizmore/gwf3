<?php

$headers = array(
	array('WCID'),
	array('TITLE'),
	array('CAT'),
	array('SOL'),
	array('BTN'),
);

echo GWF_Form::start();
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);
foreach ($tVars['flags'] as $flag)
{
	$flag instanceof WC_Warflag;
	$solved = $flag->getVar('wf_solved_at') !== NULL;
	echo GWF_Table::rowStart();
	echo GWF_Table::column($flag->getID());
	$class = 'wc_chall_solved_'. ($solved ? '1' : '0');
	echo GWF_Table::column(GWF_HTML::anchor($flag->getURL(), $flag->getTitle()), $class);
	echo GWF_Table::column($flag->displayCat());
	if ($flag->isWarchall())
	{
		echo GWF_Table::column('');
		echo GWF_Table::column('');
	}
	elseif ($solved)
	{
		echo GWF_Table::column('SOLVED!');
		echo GWF_Table::column('');
	}
	else
	{
		echo GWF_Table::column(sprintf('<input type="text" name="password[%s]" value="">', $flag->getID()));
		echo GWF_Table::column(sprintf('<input type="submit" name="button[%s]" value="CHECK">', $flag->getID()));
	}
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo GWF_Form::end();
