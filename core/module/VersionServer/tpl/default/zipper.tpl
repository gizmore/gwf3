<h1>{$lang->lang('zipper_intro')}</h1>
{$form}

{*

<div class="contentintro">{$lang->lang('zipper_intro')}</div>
<form action="{$form_action}" method="post">
	{CSRF::hiddenForm()}
	<div>{$lang->lang('style')}:&nbsp;<input type="text" name="style" value="default" /></div> 
	<table>
		<tr>
			<th></th>
			<th>{$lang->lang('group')}</th>
		</tr>
{foreach $modules as $m}
		<tr>
			<td><input type="checkbox" name="mod_{$m[0]}" /></td>
			<td>{$m[0]}</td>
		</tr>
{/foreach}
		<tr>
			<td colspan="2"><input type="submit" name="zipper" value="{$lang->lang('btn_zip')}" /></td>
		</tr>
	</table>
</form>

*}