<!-- @start gwf_navigation -->
<ol class="gwf_navigation">
	<li>
		<!-- @start section {$navi['category_name']} -->
		<h2>{$navi['category_name']}</h2>
		<ul>
{foreach $navi['subs'] as $sub}
{$show->display($sub)|indent:3:"\t"}
{/foreach}
{foreach $navi['links'] as $link}
			{link pre='<li>' post='</li>' text={$link['page_title']} url={$link['page_url']} title={$link['page_meta_desc']}}
{/foreach}
		</ul>
		<!-- @start section {$navi['category_name']} -->
	</li>
</ol>
<!-- @end gwf_navigation -->
