<thead>
{$raw}
<tr>
{foreach $headers as $head}
	<th class="nowrap">
	{if $head[1] !== false}
		<a rel="nofollow" class="gwf_th_asc{if $head[3]===true}_sel{/if}" href="{$head[1]}"></a>
		<a rel="nofollow" class="gwf_th_desc{if $head[4]===true}_sel{/if}" href="{$head[2]}"></a>
	{/if}
	</th>
{/foreach}
</tr>
<tr>
{foreach $headers as $head}
	<th class="gwf_th{if isset($head[5]) && $head[5] === true}_sel{/if}">{$head[0]}</th>
{/foreach}
</tr>
</thead>
