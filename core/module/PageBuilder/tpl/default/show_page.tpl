<div class="GWF_PB_head">
	<div class="fl">{$title}</div>
	<div class="fr">{$lang->lang('created_on')}: {$created}</div>
	<div class="cb"></div>
</div>
<hr/>

<div class="GWF_PB_content">
{$content}
</div>

<hr/>

<div class="GWF_PB_foot">
	<div class="fl">
{if $page->isOptionEnabled(GWF_Page::SHOW_AUTHOR)}{$lang->lang('author')}: <a href="{$root}profile/{$author}">{$author}</a>, {/if}
	{$lang->lang('page_views')}: {$page_views}
	</div>
	<div class="fr">
{if $author === $user->displayUsername()}
  <a class="gwf_button " href="index.php?mo=PageBuilder&me=Edit&pageid={$page->getID()}" title="Edit">
    <span class="gwf_btn_edit"></span>
  </a>
{/if}
		{if $page->isOptionEnabled(GWF_Page::SHOW_MODIFIED)}{$lang->lang('modified_on')}: {$modified}{/if}
	</div>
	<div class="cb"></div>
{if $page->isOptionEnabled(GWF_Page::SHOW_TRANS)}
{if $translations == NULL}	
{elseif $translations != array()}
	<div>{$lang->lang('translations')}: {$translations}</div>
{elseif $translations == array()}
{$lang->lang('msg_no_trans')}
{/if}
{/if}
{if $page->isOptionEnabled(GWF_Page::SHOW_SIMILAR)}
	<div>{$lang->lang('similar_pages')}: 
{foreach $similar as $sim}
{/foreach}
	</div>
{/if}
</div>
<hr/>

{if $page->isOptionEnabled(GWF_Page::COMMENTS)}
{$pagemenu}

{$comments}

{$pagemenu}

{$form_reply}
{/if}