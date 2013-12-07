<?php
####conf superword,g,x,s,gizmore,,,millis,g,x,i,50,,,blocking,g,x,b,0,,,triggers,g,x,s,".",,,floodmillis,g,y,i,800
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<setting>] [<value>]. Configure core bot settings.',
		'avail' => '%BOT% config vars: %s.',
		'set' => 'Successfully set %s to %s.',
		'show' => 'Variable %s is of type %s, defaults to %s. Value: %s.',
		'invalid' => 'Variable %s is of type %s, which renders your input invalid.',
	),
);
$plugin = Dog::getPlugin();

$argv = $plugin->argv();
$argc = count($argv);

$vars = $plugin->getConfigVars();

if ($argc === 0)
{
	$out = '';
	foreach ($vars as $var)
	{
		$var instanceof Dog_Var;
		$out .= sprintf(', %s', $var->getName());
	}
	
	return $plugin->rply('avail', array(substr($out, 2)));
}

elseif ($argc === 1)
{
	if (false === ($var = Dog_Var::getVar($vars, $argv[0])))
	{
		return Dog::rply('err_unk_var');
	}
	$varname = $var->getName();
	$vartype = $var->displayType();
	$vardeft = $var->getDefault();
	$curvalu = Dog_Conf_Bot::getConf($varname, $vardeft);
	
	return $plugin->rply('show', array($varname, $vartype, $vardeft, $curvalu));
}

elseif ($argc === 2)
{
	if (false === ($var = Dog_Var::getVar($vars, $argv[0])))
	{
		return Dog::rply('err_unk_var');
	}
	
	$varname = $var->getName();
	$vartype = $var->displayType();
	$vardeft = $var->getDefault();
	$curvalu = Dog_Conf_Bot::getConf($varname, $vardeft);

	if (!Dog_Var::isValid($var->getType(), $argv[1]))
	{
		return $plugin->rply('invalid', array($varname, $vartype));
	}
	
	Dog_Conf_Bot::setConf($varname, $argv[1]);
	
	return $plugin->rply('set', array($varname, $argv[1]));
}

else
{
	$plugin->showHelp();
}
?>
