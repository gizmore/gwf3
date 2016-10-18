<div>
<table id="gwfchat_pubmsg" class="t" border="2">
<?php foreach ($tVars['msgs'] as $msg) { ?>
	<tr>
		<td></td>
		<td><?php echo $msg->displayFrom(); ?></td>
		<td></td>
		<td><?php echo $msg->displayMessage(); ?></td>
	</tr>
<?php } ?>
</table>
<div><?php echo $tVars['form']; ?></div>
</div>