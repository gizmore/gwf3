<h1><?php echo $tLang->lang('zipper_intro'); ?></h1>
<?php echo $tVars['form']; ?>

<!-- 

<div class="contentintro"><?php #echo $tLang->lang('zipper_intro'); ?></div>
<form action="<?php #echo $tVars['form_action']; ?>" method="post">
	<?php #echo CSRF::hiddenForm(); ?>
	<div><?php #echo $tLang->lang('style'); ?>:&nbsp;<input type="text" name="style" value="default" /></div> 
	<table>
		<tr>
			<th></th>
			<th><?php #echo $tLang->lang('group'); ?></th>
		</tr>
<?php #foreach ($tVars['modules'] as $m) { ?>
		<tr>
			<td><input type="checkbox" name="mod_<?php #echo $m[0]; ?>" /></td>
			<td><?php # echo $m[0]; ?></td>
		</tr>
<?php #} ?>
		<tr>
			<td colspan="2"><input type="submit" name="zipper" value="<?php #echo $tLang->lang('btn_zip'); ?>" /></td>
		</tr>
	</table>
</form>

 -->