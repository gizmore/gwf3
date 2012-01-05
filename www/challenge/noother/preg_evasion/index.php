<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Preg Evasion');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/noother/preg_evasion/index.php', false);
}
$chall->showHeader();
# -------------------------- #

# Your Hacky CSRF protected form (It is just for preventing csrf Oo)
final class NootherForm { public function validate_text($m,$v) { return false; } }
$validator = new NootherForm();
$form = the_form($chall, $validator);

# Your sourcecode
if (isset($_GET['source']))
{
	$code = file_get_contents('challenge/noother/preg_evasion/index.php');
	echo GWF_Message::display('[code lang=php title=preg_evasion]'.$code.'[/code]');
}

# Your trigger
if (isset($_POST['hackit']) && isset($_POST['text']) && is_string($_POST['text']))
{
	if (false !== ($error = $form->validate(Module_WeChall::instance()))) {
		echo $error;
	}
	else
	{
		# Let's examine your POST
		$text = $_POST['text'];

		# Not Evil?
		if (the_preg_match($chall, $text))
		{
			#But Evil?
			if (the_strpos($chall, $text))
			{
				# Try to get here!
				$chall->onChallengeSolved(GWF_Session::getUserID());
			}
		}
	}
}

# Your mission
$href_src = 'sourcecode.php';
$href_src2 = 'index.php?source=show';
echo GWF_Box::box($chall->lang('info', array($href_src, $href_src2)), $chall->lang('title'));

# Your form
display_the_form($chall, $form);

# Your footer
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');


# Owning it ... priceless

############################
### Now here is the code ###
############################
/**
 * We don't like the text "evilfunction" and "badmethod".
 */
function the_preg_match(WC_Challenge $chall, $text)
{
	if (1 === preg_match('#^.*((?:badmethod)|(?:evilfunction)).*$#s', $text, $matches)) {
		echo GWF_HTML::error($chall->lang('title'), $chall->lang('evil', array($matches[1])));
		return false;
	}
	else {
		echo GWF_HTML::message($chall->lang('title'), $chall->lang('lovely'));
		return true;
	}
	
}

/**
 * However if you pass the method above, we want to have "evilfunction" and "badmethod".
 * Paradox?
 */
function the_strpos(WC_Challenge $chall, $text)
{
	return strpos($text, 'badmethod') !== false && strpos($text, 'evilfunction') !== false; 
}

/*
 * A very simple GWF/WC form... prevents csrf Oo...
 */
function the_form(WC_Challenge $chall, $validator)
{
	$data = array(
		'div' => array(GWF_Form::HEADLINE, '', $chall->lang('noote')),
		'text' => array(GWF_Form::STRING, '', $chall->lang('th_text')),
		'hackit' => array(GWF_Form::SUBMIT, $chall->lang('btn_hackit')),
	);
	return new GWF_Form($validator, $data);
}

function display_the_form(WC_Challenge $chall, GWF_Form $form)
{
	echo $form->templateY($chall->lang('ft_the_form'));
}
?>

