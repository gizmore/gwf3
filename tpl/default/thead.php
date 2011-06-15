<thead>
<tr>
<?php foreach ($tVars['headers'] as $head) {
	echo '<th class="nowrap">';
	if ($head[1] !== false) {
			printf('<a class="gwf_th_asc%s" href="%s"></a>', $head[3]===true?'_sel':'', $head[1]);
			printf('<a class="gwf_th_desc%s" href="%s"></a>', $head[4]===true?'_sel':'', $head[2]);
	}
	echo '</th>';
} ?>
</tr>
<tr>
<?php foreach ($tVars['headers'] as $head)
{
	printf('<th class="gwf_th%s">%s</th>', isset($head[5]) && $head[5] === true?'_sel':'', $head[0]);
}
?>
</tr>
</thead>
