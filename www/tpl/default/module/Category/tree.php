<?php
echo '<pre>'.PHP_EOL;
// $lastpid = '0';
$tabs = array('0' => '');

$cat = array_shift($tVars['cats']);

while (count($tVars['cats']) !== 0)
{
	
}



foreach ($tVars['cats'] as $cat)
{
	$id = $cat['id'];
	$pid = $cat['pid'];
	if (!isset($tabs[$id]))
	{
		$tabs[$id] = $tabs[$pid].'+-';
	}
	
	$tab = $tabs[$pid];
	echo $tab;
	
	$moveup = sprintf('<a href="%sindex.php?mo=Category&me=Tree&up=%s">^</a>', GWF_WEB_ROOT, $cat['id']);
	$movedo = sprintf('<a href="%sindex.php?mo=Category&me=Tree&up=%s">v</a>', GWF_WEB_ROOT, $cat['id']);
	
	echo $cat['id'].'['.$cat['key'].']'.$moveup.' '.$movedo.PHP_EOL;
	
	
}
echo '</pre>'.PHP_EOL;



?>
