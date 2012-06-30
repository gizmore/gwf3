<?php echo GWF_Table::start(); ?>
<thead>
	<?php echo $tVars['raw_head']; ?>
	<tr>
	<?php foreach ($tVars['headers'] as $head) {
		echo '<th class="nowrap">';
		if ($head[1] !== false) {
			echo sprintf('<a class="gwf_th_asc%s" href="%s"></a>', $head[3]===true?'_sel':'', $head[1]);
			echo sprintf('<a class="gwf_th_desc%s" href="%s"></a>', $head[4]===true?'_sel':'', $head[2]);
		}
		echo '</th>';
	} ?>
	</tr>
	<tr>
	<?php foreach ($tVars['headers'] as $head)
	{
		echo sprintf('<th class="gwf_th%s">%s</th>', isset($head[5]) && $head[5] === true?'_sel':'', $head[0]);
	}
	?>
	</tr>
</thead>
<?php
$even = 1;
foreach ($tVars['data'] as $row) { ?> 
<tr class="<?php echo sprintf('gwf_trd_%d', $even); $even = 1 - $even; ?>">
	<?php foreach ($row as $col) { ?>
		<td><?php echo $col; ?></td>	
	<?php } ?>
</tr>
<?php } ?>
	<?php echo $tVars['raw_body']; ?>
<?php echo GWF_Table::end(); ?>
