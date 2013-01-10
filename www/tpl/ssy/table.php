<table><?php echo $tVars['raw_head']; ?>
<tr>
<?php foreach ($tVars['headers'] as $head)
{
	$s = $head['is_selected'];
	$class = $s ? 'gwf_th_sel' : 'gwf_th';
	$ascdesc = $s ? sprintf(' gwf_th_%s', $head['dir']) : '';
	echo sprintf('<th class="%s%s">%s</th>', $class, $ascdesc, $head['link']);
}
?>
</tr><?php echo $tVars['raw_body']; ?>
<?php
$even = 1;
foreach ($tVars['data'] as $row) { ?> 
<tr class="<?php echo sprintf('ssy_table_even_%d', $even); $even = 1 - $even; ?>">
	<?php foreach ($row as $col) { ?>
		<td>
			<?php echo $col; ?>
		</td>	
	<?php } ?>
</tr>
<?php } ?>
</table>
