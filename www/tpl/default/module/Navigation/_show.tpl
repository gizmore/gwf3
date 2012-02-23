{if !empty($navi['subs']) || !empty($navi['links'])}
<li>
	<!-- @start category {$navi['category_name']} -->
	{$navi['category_name']}
	<ul>
{foreach $navi['subs'] as $sub}
{$show->display($sub)|indent:3:"\t"}
{/foreach}

{foreach $navi['links'] as $link}
		{link pre='<li>' post='</li>' text={$link['page_title']} url={$link['page_url']} title={$link['page_meta_desc']}}
{/foreach}
	</ul>
	<!-- @end category {$navi['category_name']} -->
</li>
{/if}
