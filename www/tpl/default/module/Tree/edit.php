<?php
echo $tVars['formc'];


if ($tVars['class'] !== NULL)
{
	echo '<pre>'.PHP_EOL;
	showTree($tVars['class']);
	echo '</pre>'.PHP_EOL;
}

function showTree(GWF_Tree $gdo)
{
	if (false === ($result = $gdo->select('cat_tree_id id, cat_tree_key `key`, cat_tree_pid pid, cat_tree_left `left`, cat_tree_right `right`', '', 'cat_tree_left ASC')))
	{
		echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		return false;
	}
	
	$stack = array();
	
	$class = urlencode(Common::getGetString('class'));
	
	while (false !== ($node = $gdo->fetch($result, GDO::ARRAY_A)))
	{
		while ( (count($stack) > 0) && ($stack[count($stack)-1] < $node['right']) )
		{
			array_pop($stack);
		}
		$btnU = sprintf('<a href="index.php?mo=Tree&me=Edit&class=%s&up=%s">^</a>', $class, $node['id']);
		$btnD = sprintf('<a href="index.php?mo=Tree&me=Edit&class=%s&down=%s">v</a>', $class, $node['id']);
		echo str_repeat('  ',count($stack)) . $node['key'] . ' ' . $btnU . ' ' . $btnD . PHP_EOL;
		
		$stack[] = $node['right'];
	}
	
	$gdo->free($result);
	
	
}

?>
