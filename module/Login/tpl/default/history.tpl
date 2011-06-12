{box content=$cleared}

{$pagemenu}

<table>
	<thead>{$tablehead}</thead>
	<tbody>
	{foreach $history as $h}
		<tr class="{cycle values="odd,even"}">
			<td class="gwf_date">{$h->displayDate()}</td>
			<td>{$h->displayIP()}</td>
			<td>{$h->displayHostname()}</td>
		</tr>
	{/foreach}
	</tbody>
</table>

{$pagemenu}

{$form}

