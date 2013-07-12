<?php
$headers = array(
	array('Pos', 'wf_order', 'ASC'),
	array('Score', 'wf_score', 'ASC'),
	array('Title', 'wf_title', 'ASC'),
	array('Solvers', 'wf_solvers', 'ASC'),
	array('LastSolvedBy', 'user_name', 'ASC'),
	array('LastSolved', 'wf_last_solved_at', 'ASC'),
// 	array('Flags'),
);
$logged_in = GWF_User::isLoggedIn();

if ($logged_in)
{
	$headers[] = array('Unlock');
}

$box = $tVars['box']; $box instanceof WC_Warbox;
$site = $tVars['site']; $site instanceof WC_Site;

$user = GWF_Session::getUser();

$href_flags = $box->hrefFlags();

echo $tVars['site_quickjump'];

echo GWF_Box::box($tLang->lang('info_warbox_details', array($site->displayName(), $box->displayName(), count($tVars['data']))), $tLang->lang('title_warbox_details', array($site->displayName(), $box->displayName())));

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

function solving_form($tVars, WC_Warflag $flag)
{
	$form = '';
	$form .= GWF_Form::start(true, GWF_Form::ENC_DEFAULT, 'post', false);
	$form .= sprintf('<input type="hidden" name="wfid" value="%s" />', $flag->getID());
	$form .= sprintf('<input type="text" name="password_solution" value="" />');
	$form .= sprintf('<input type="submit" name="igotitnow" value="!" />');
	$form .= GWF_Form::end();
// 	$data = array(
// 		'flagid' => array(GWF_Form::HIDDEN, $flag->getID()),
// 		'solution' => array(GWF_Form::STRING, ''),
// 	);
// 	$form = new GWF_Form($tVars['method'], $data);
// 	return $form->templateX();
	return $form;
}

foreach ($tVars['data'] as $flag)
{
	$flag instanceof WC_Warflag;
	
	$solved = $flag->getVar('wf_solved_at') !== NULL;
	
	echo GWF_Table::rowStart();
	
	echo GWF_Table::column($flag->getVar('wf_order'), 'gwf_num');
	
	echo GWF_Table::column($flag->getVar('wf_score'), 'gwf_num');
	
	
	$class = $solved ? 'wc_chall_solved_1' : 'wc_chall_solved_0';
	if ('' === ($url = $flag->getVar('wf_url')))
	{
		echo GWF_Table::column($flag->display('wf_title'), $class);
	}
	else
	{
		echo GWF_Table::column(GWF_HTML::anchor($url, $flag->getVar('wf_title'), NULL, $class));
	}
	
	echo GWF_Table::column(GWF_HTML::anchor($flag->hrefSolvers(), $flag->getVar('wf_solvers')), 'gwf_num');
	
	echo GWF_Table::column($flag->displayLastSolvedBy());
	
	echo GWF_Table::column($flag->displayLastSolvedDate(), 'gwf_date');
	
	if ($logged_in)
	{
		if (!$flag->isWarflag())
		{
			echo GWF_Table::column('--ssh--only--');
		}
		elseif ($solved)
		{
			echo GWF_Table::column('Well Done');
		}
		else
		{
			echo GWF_Table::column(solving_form($tVars, $flag));
		}
	}
// 	if ( ($user !== false) && () ) 
// 	{
// 		echo GWF_Table::column(GWF_Button::bell($href_flags, 'Enter Flags'));
// 	}
// 	else
// 	{
// 		echo GWF_Table::column();
// 	}
	
	
	echo GWF_Table::rowEnd();
}

echo GWF_Table::end();
