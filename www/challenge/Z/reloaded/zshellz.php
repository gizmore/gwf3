<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Z - Reloaded (ZZhellZ');
require_once 'challenge/gwf_include.php';
GWF_Website::addCSS(GWF_WEB_ROOT.'challenge/Z/reloaded/css/zshellz2.css');
require_once('challenge/html_head.php');
require_once('challenge/Z/reloaded/zshellz_answers.php');

# Constants
define('ZRELOAD_NUM_LINES', 15);

global $chall;
global $zshellz;
global $prompt;
global $title;
global $allowcmd;
global $noresponse;


$title = 'Z - Reloaded';
if (false === ($chall = WC_Challenge::getByTitle($title)))
{
	$chall = WC_Challenge::dummyChallenge($title, 6, '/challenge/Z/reloaded', false);
}

$prompt = '>';
$zshellz = array(
	ZRELOAD_LOCALHOST => array($chall->lang('your_box'), array('root@trinity_localhost#')),
//	ZRELOAD_REMOTE => array('Remote Shell', 'root@10.2.2.2#'),
//	ZRELOAD_MSSQL => array('ms sql database server', 'c:\\'),
);



# execute comand
$level = (int) Common::getPost('level', 1);

# do it
$ct = htmlspecialchars($chall->getVar('chall_title'), ENT_QUOTES);
//$css = array('/challenge/Z/reloaded/css/zshellz.css');
//html_head($ct, false, true, array(), true, $css);
html_head($ct, false);
$chall->showHeader(true);

zreload($level);

function zreloadGetDebug()
{
	$data = GWF_Session::getSessData();
	foreach ($data as $key => $value)
	{
		if (Common::strStartsWith($key, 'csrf'))
		{
			continue;
		}
		if (in_array($key, array('sess_expire', 'returnto', 'user')))
		{
			continue;
		}
		var_dump($key);
		var_dump($value);	
	}
	
}

# Show a shell
function zreloadShowShell($shellid, $narrator, $level, $onfocus=true)
{
	global $prompt, $title;
	
	$sn = 'zreload_shell_'.$shellid;
	if (!GWF_Session::exists($sn))
	{
		GWF_Session::set($sn, array());
	}
	
?>
<div class="chall_rel_shell_wrap box">
	<div class="chall_rel_shell_title"><?php echo sprintf('%s (Level %d)', $title, $level); ?></div>
	<div class="chall_rel_shell">
		<div id="chall_rel_nar_<?php echo $shellid; ?>"><?php echo $narrator; ?></div>
		<div class="chall_rel_shell_out">
			<div><?php echo zreloadPrintShell($shellid); ?></div>
		</div>
		<hr/>
		<form action="zshellz.php" method="post">
		<?php echo GWF_CSRF::hiddenForm(''); ?>
		<div><input type="hidden" name="level" value="<?php echo $level; ?>" /></div>
		<div><input type="hidden" name="shellid" value="<?php echo $shellid; ?>" /></div>
		<div style="color: white;">
			<?php echo $prompt; ?>
			<input class="chall_rel_shell_input" id="zshell<?php echo $shellid; ?>" type="text" name="input" value="" /> 
			<input type="submit" name="cmd" value="Enter" />
		</div>
		</form>
	</div>
</div>
<!--<pre><?php #echo zreloadGetDebug(); ?></pre>-->

<?php
if ($onfocus) {
?>
<script type="text/javascript">
var input = document.getElementById('zshell<?php echo $shellid; ?>');
input.focus();
</script>
<?php
}

} # end of show shell

function zreloadPrintShell($shellid)
{
	$sn = 'zreload_shell_'.$shellid;
	if (!GWF_Session::exists($sn))
	{
		GWF_Session::set($sn, array());
	}
	
	$lines = GWF_Session::get($sn);
	GWF_Session::set($sn, array_slice($lines, -ZRELOAD_NUM_LINES));
	
	$back = '';
	foreach ($lines as $line)
	{
		$back .= '<div>'.$line.'</div>';
	}
	return $back;
}

# split stage, check if level is reached
function zreload($level)
{
	# check level
	$level = (int) $level;
	if (!GWF_Session::exists('zreload'))
	{
		GWF_Session::set('zreload', 1);
		$level = 1;
	}
	$sesslvl = GWF_Session::get('zreload');
	if ($sesslvl != $level) # THE Levelid via POST is useless
	{ 
		$level = (int)$sesslvl;
	}
	if ($level < 1)
	{
		$level = 1;
	}
	
	# check shellid
	global $zshellz, $allowcmd, $noresponse;
	$allowcmd =true;
	$noresponse = false;
	$shellid = (int) Common::getPost('shellid');
	#echo $shellid;
	if ($shellid == 0)
	{
		$shellid = ZRELOAD_LOCALHOST;
	}
	
	if (!(array_key_exists($shellid, $zshellz)))
	{
		htmlDisplayError('Unknown Shell');
	}
	else
	{
		if (false !== ($input = Common::getPostString('input', false)))
		{
			$input = preg_replace('/[ ]{2,}/', ' ', $input);
		}
		
		zreload_do_before_actions();
		
		# append your input to level
		if ($input !== false && $noresponse===false)
		{
			zreloadAppendToShell($shellid, $input, true);
		}
		
		$answers = zshellzAnswers($level);
		
		if ($input !== false)
		{
			$solved = zreloadCheckInput($shellid, $input, $answers);
		}
		
		$level = GWF_Session::get('zreload');
		
		if ($input && $solved)
		{
			zreloadNextLevel($level);
			$level++;
		}
		
		
		$narrator = zshellzNarrator($level);
		
		zreloadShowShell($shellid, $narrator, $level, true);
		
	}
}

function zreloadNextLevel($oldLevel)
{
	$oldLevel++;
	GWF_Session::set('zreload', $oldLevel);
	$actions = zshellzActionsAfter($oldLevel);
	foreach ($actions as $action => $data)
	{
		zreloadAction($action, $data);
	}
	$actions = zshellzActionsBefore($oldLevel);
	foreach ($actions as $action => $data)
	{
		zreloadAction($action, $data);
	}
}

function zreloadAction($action, $data)
{
	switch ($action)
	{
		case ZRELOAD_CLEAR: zreloadClearShells(); break;
		case ZRELOAD_LOCALHOST: zreloadAppendToShell(ZRELOAD_LOCALHOST, $data); break;
		case ZRELOAD_REMOTE: zreloadAppendToShell(ZRELOAD_REMOTE, $data); break;
		case ZRELOAD_MSSQL: zreloadAppendToShell(ZRELOAD_MSSQL, $data); break;
		case ZRELOAD_SOLVED: global $chall; $chall->onChallengeSolved(GWF_Session::getUserID()); break;
		case ZRELOAD_PROMPT: global $prompt; $prompt = $data; break;
		case ZRELOAD_TITLE: global $title; $title = $data; break;
		case ZRELOAD_NOCMD: global $allowcmd; $allowcmd = false; break;
		case ZRELOAD_NO_RESPONSE: global $noresponse; $noresponse = true; break;
	}
}

function zreloadGetShellConfig($shellid){
	global $zshellz;
	if (!isset($zshellz[$shellid]))
	{
		htmlDisplayError('Unknown Shell ID in '.__FILE__.' Line '.__LINE__);
		return array('ERR', 'ERR');
	}
	return $zshellz[$shellid]; 
}

function zreloadAppendToShell($shellid, $input, $withPrompt=false, $withXSS=false)
{
	global $prompt, $noresponse;
	
	if ($withPrompt)
	{
//		$shellcfg = zreloadGetShellConfig($shellid);
//		$prompt = $shellcfg[1];
		$input = $prompt.' '.$input;
	}
	
	if (!$withXSS)
	{
		$input = htmlspecialchars($input);
#		$input = nl2br($input);
	}
	
	$sessname = 'zreload_shell_'.$shellid;
	
	if (!GWF_Session::exists($sessname))
	{
		GWF_Session::set($sessname, array());
	}
	
/*	if ($noresponse === true) {
		$input = 'Authentication failed.';
	}*/
	
	$input = explode(PHP_EOL, $input);
	GWF_Session::set($sessname, array_merge(GWF_Session::get($sessname), $input));
}

function zreloadClearShells()
{
	zreloadClearShell(ZRELOAD_LOCALHOST);
	zreloadClearShell(ZRELOAD_REMOTE);
	zreloadClearShell(ZRELOAD_MSSQL);
}

function zreloadClearShell($shellid)
{
	GWF_Session::set('zreload_shell_'.$shellid, array());
}

function zreloadCheckInput($shellid, $input, array $answers)
{
	global $allowcmd, $noresponse;
	
	$level = GWF_Session::get('zreload');
	
	# replace multi spaces.
	$input = preg_replace('/[ ]{2,}/', ' ', $input);
	$input_cmd = Common::substrUntil($input, ' ');
	$function = 'zreload_func_'.$input_cmd;
	
	foreach ($answers as $answer)
	{
		$answer_cmd = Common::substrUntil($answer, ' ');
		
		
		# DBG
//		echo sprintf('Checking<br/>');
//		echo $input.'<br/>';
//		echo $answer.'<br/>';
//		echo '<hr/>';
		
//		EVIL!	
//		if ($level === 7  || $level ===8)
//		{
//			$input =strtolower($input);
//		}
//		
		if ($input === $answer)
		{
			return true;
		}
	}	
	
	foreach ($answers as $answer)
	{
		if ($input === 'ssh -L 222:164.109.44.69:22 10.2.2.2' && $level === 9)
		{
			$output = 'Almost, but think again :-) Or read the manual.';
			break;
		}
		
		elseif ($input_cmd === $answer_cmd && $allowcmd)
		{
			$output = 'Yes, you have to use '.$answer_cmd.'.';
			break;
		}
		elseif (function_exists($function) && $allowcmd)
		{
			$output = call_user_func($function, $shellid, Common::substrFrom($input, ' '));
			break;
		}
		elseif ($input_cmd === '')
		{
			$output = '';
		}
		elseif ($allowcmd)
		{
			$output = 'Unknown command: '.htmlspecialchars($input_cmd);
		}
		elseif ($noresponse)
		{
			$output = 'Authentication failure.';
		}
		else
		{
			if ($input_cmd === 'reset')
			{
				$output = zreload_func_reset($shellid, '');
			}
			else
			{
				$output = 'Wrong.';
			}
		}
	}
	
	zreloadAppendToShell($shellid, $output);
	
	return false;
}

###########################
### Easteregg functions ###
###########################
function zreload_func_help($shellid, $args)
{
	if (false === ($chall = WC_Challenge::getByTitle('Z - Reloaded')))
	{
		$chall = WC_Challenge::dummyChallenge('Z - Reloaded', 6, '/challenge/Z/reloaded', false);
	}
	return $chall->lang('cmd_help');
}

function zreload_func_clear($shellid, $args)
{
	zreloadClearShell($shellid);
	return '';
}

function zreload_func_reset($shellid, $args)
{
	GWF_Session::set('zreload', 1);
	zreloadClearShells();
	zreload_do_before_actions();
	return 'All cleared';
}

function zreload_func_ls($shellid, $args)
{
	$args = explode(' ', $args);
	switch ($args[0])
	{
		case '/': case '': return 'etc, bin, usr, root, pron, games';
		case 'bin': case '/bin': return 'clear ls man reset';
		case 'pron': case '/pron': return 'quangntenemy_vs_bbq.mpg unhandled_moarns.mp3 mutant_vampire_lesbians.avi';
		case 'games': case '/games': return 'CavemanUghLympics GianaSister PsychoPig TheLastNinja';
		case 'games/CavemanUghLympics': case '/games/CavemanUghLympics': return 'Ugah Agah Ugah';
		default: return 'Enough Eastereggs.';
	}
}

function zreload_func_man($shellid, $args)
{
	if ('' === ($args = trim($args)))
	{
		zreloadAppendToShell($shellid, 'Try man google.', false, true);
		return;
	}
	$args = htmlspecialchars($args, ENT_QUOTES);
	$href = 'http://en.lmgtfy.com/?q=man+'.$args;
	$a = '<a style="color: #ccf;" href="'.$href.'">man pages for '.$args.'</a>';
	$txt = sprintf('Here are the %s.', $a);
	zreloadAppendToShell($shellid, $txt, false, true);
}

function zreload_do_before_actions()
{
	# Do action for level
	$actions = zshellzActionsBefore(GWF_Session::get('zreload'));
	foreach ($actions as $action => $data)
	{
		zreloadAction($action, $data);
	}
}

require_once('challenge/html_foot.php');
?>