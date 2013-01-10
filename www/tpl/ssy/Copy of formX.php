<?php
echo sprintf('<form action="%s" method="%s" enctype="%s">', $tVars['action'], $tVars['method'], $tVars['encoding']);
echo '<table>';
if ($tVars['title'] !== false) {
	echo sprintf('<tr><th colspan="%d">%s</th></tr>', $tVars['num_visible_cells'], $tVars['title']);
}

if ($tVars['with_heads'])
{
	echo '<tr>';
	foreach ($tVars['inputs'] as $input)
	{
		switch ($input[0])
		{
			default:
				echo sprintf('<td>%s</td>', $input[2]);
				break;
		}
	}
	echo '</tr>';
}

echo '<tr>';
foreach ($tVars['inputs'] as $input)
{
	switch ($input[0])
	{
		default:
			echo sprintf('<td>%s</td>', $input[1]);
			break;
		
	}
}
echo '</tr>';
echo '</table></form>';

?>