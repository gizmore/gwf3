<section class="GWF_PB_page">

<header class="GWF_PB_head">
	<div class="fl">{$title}</div>
	<div class="fr">{$lang->lang('created_on')}: <span class="gwf_date">{$created}</span></div>
	<div class="cb"></div>
</header>

<article class="GWF_PB_content">
{$content}
</article>

<footer class="GWF_PB_foot">
	<div class="fl">
{if $page->isOptionEnabled(GWF_Page::SHOW_AUTHOR)}{$lang->lang('author')}: <a href="{$root}profile/{$author}">{$author}</a>, {/if}
	{$lang->lang('page_views')}: {$page_views}
	</div>
	<div class="fr">
{if $edit_permission}
  <a class="gwf_button " href="index.php?mo=PageBuilder&me=Edit&pageid={$page->getID()}" title="Edit">
    <span class="gwf_btn_edit"></span>
  </a>
{/if}
	{if $page->isOptionEnabled(GWF_Page::SHOW_MODIFIED)}{$lang->lang('modified_on')}: {$modified}{/if}
	</div>
	<div class="cb"></div>

{if $page->isOptionEnabled(GWF_Page::SHOW_TRANS)}
{if $trans_string == ''}	
	<div>{$lang->lang('msg_no_trans', array($page->hrefTranslate()))}</div>
{else}
	<div>{$lang->lang('translations')}: {$trans_string}</div>
	<div>{$lang->lang('translatethis', array({$page->hrefTranslate()}))}</div>
{/if}
{/if}

{if $page->isOptionEnabled(GWF_Page::SHOW_SIMILAR)}
	<div>{$lang->lang('similar_pages')}: 
{foreach $similar as $sim}
{/foreach}
	</div>
{/if}
</footer>

</section>

{if $page->isOptionEnabled(GWF_Page::COMMENTS)}
<section class="GWF_PB_Comments">
{$pagemenu}

{$comments}

{$pagemenu}

{$form_reply}
</section>
{/if}
