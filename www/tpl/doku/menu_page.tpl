<div class="gwf_pagemenu">
<span>
{foreach $pagelinks as $id => $link}
{if $link === false}
	...
{elseif $link === ''}
	<a class="gwf_pagemenu_sel" {$link}>[{$id}]</a>
{else}
	<a {$link}>[{$id}]</a>
{/if}
{/foreach}
</span>
</div>
