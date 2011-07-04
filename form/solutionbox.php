<?php
function formSolutionbox(WC_Challenge $chall)
{
	GWF_Javascript::focusElementByID('answer');

	$form = formSolutionboxForm($chall);
	
	echo 
		'<div id="wc_solutionbox">'.PHP_EOL.
		$form->templateX(WC_HTML::lang('ft_solution', array($chall->display('chall_title')))).
		'</div>'.PHP_EOL;
}

function formSolutionboxForm(WC_Challenge $chall)
{
	$data = array(
		'answer' => array(GWF_Form::STRING, '', WC_HTML::lang('th_solution')),
		'solve' => array(GWF_Form::SUBMIT, WC_HTML::lang('btn_solve')),
	);
	return new GWF_Form($chall, $data);
}

function formSolutionboxValidate(WC_Challenge $chall)
{
	$form = formSolutionboxForm($chall);
	if (false !== ($error = $form->validate(Module_WeChall::instance()))) {
		return $error;
	}
	return false;
}
?>