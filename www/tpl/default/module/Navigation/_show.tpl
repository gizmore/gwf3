{foreach $navi => $category}
	<li>
		{$category['category_name']}
		<ul>
{if NULL != $category['subs']}{foreach $category['subs'] as $sub}
{$show->display($sub)|indent:3}
{/foreach}{/if}

{foreach $category['links'] => $link}
			<li>{link text={$link['page_title']} url={$link['page_url']} title={$link['page_meta_descr']}}</li>
{/foreach}
		</ul>
	</li>
{/foreach}
