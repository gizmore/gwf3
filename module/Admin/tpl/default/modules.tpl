{box content="$install_all"}

<table>
	{$tablehead}
	<tbody>
		{foreach $modules as $name => $mod}
		<tr class="gwf_{cycle values='odd,even'}">
			<td>{$mod['priority']}</td>
			<td></td>
			{if $mod['vdb'] == 0 || $mod['enabled'] == 0}
			<td><span style="color:#f00">{$mod['name']}</span></td>
			{else}
			<td>{$mod['name']}</td>
			{/if}
			{if $mod['vdb'] < $mod['vfs']}
			<td><span style="color:#f00">{$mod['vdb']}</span></td>
			{else}
			<td>{$mod['vdb']}</td>
			{/if}
			<td>{$mod['vfs']}</td>
			<td><a href="{$mod['install_url']}">{$install}</a></td>
			{if $mod['vdb'] < $mod['vfs']}
			<td></td>
			<td></td>
			{else}
			<td><a href="{$mod['edit_url']}">{$configure}</a></td>
			
			{if $mod['admin_url'] !== '#'}
			<td><a href="{$mod['admin_url']|htmlspecialchars}">{$adminsect}</a></td>
			{else}
			<td></td>
			{/if}
			
			{/if}
		</tr>
		{/foreach}
	</tbody>
</table>