{if count($matches) > 0}
<table>
	<tr><th>{$lang->lang('matches', array( count($matches)))}</th></tr>
{foreach $matches as $ip}
	<tr>
		<td>{GWF_IP6::displayIP($ip, GWF_IP_QUICK)}
	</tr>
{/foreach}
</table>
{/if}
{$form}
