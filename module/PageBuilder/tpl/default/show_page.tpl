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
	<div class="fl">{$lang->lang('author')}: {$author}, </div>
	<div class="fr">{$lang->lang('modified_on')}: {$modified}</div>
	<div class="cb"></div>
{if $translations == NULL}	
{elseif $translations != array()}
	<div>{$lang->lang('translations')}: {$translations}</div>
{elseif $translations == array()}
There are no available translations
If you like to, you can translate this page
{/if}
	<div>{$lang->lang('similar_pages')}: {$similar}</div>
</div>

<hr/>

{$pagemenu}

{$comments}

{$pagemenu}

{$form_reply}
