<h1>{$lang->lang('pt_lyrics', array($song->display('ss_artist'), $song->display('ss_title')))}</h1>

{include file="tpl/default/module/Slaytags/songbox.tpl" song=$song playing=false left=-1}

<hr/>

{if !$lyrics}
	<p>This song does not have any lyrics added yet.</p>
{else}
{foreach from=$lyrics item=l}
<div class="slay_lyrics">
	<div class="slay_lyrics_head">
		<div>{$l->getVar('ssl_date')|date}&nbsp;by&nbsp;{$l->display('user_name')}</div>
		{if $l->isEdited()}<div>{$lang->lang('info_edited', {$l->getVar('ssl_edit_date')|date})}</div>{/if}
	</div>
	<div class="slay_lyrics_body">{$l->displayLyrics()}</div>
	<div class="slay_lyrics_btns">
		{if $is_admin}
			{button type='edit' url=$l->hrefEdit() title=$lang->lang('btn_edit')}
		{/if}
	</div>
</div>
{/foreach}
{/if}