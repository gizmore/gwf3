{if $song->getVar('ss_id') < 0}
<div class="box box_c">
	<div>{$lang->lang('th_artist')}: {$song->display('ss_artist')}</div>
</div>
{else}
<div class="box box_c">
	<div>{$lang->lang('th_artist')}: {$song->display('ss_artist')}</div>
	<div>{$lang->lang('th_title')}: {$song->display('ss_title')}</div>
	<div>{$lang->lang('th_composer')}: {$song->display('ss_composer')}</div>
	<div>{$lang->lang('th_played')}: {$song->display('ss_played')}</div>
	<div>{$lang->lang('th_duration')}: {$song->getVar('ss_duration')|duration}</div>
{if $song->isRKO()}
	<div>{$lang->lang('th_rko_download')}: <a href="{$song->hrefRKO()}">{$lang->lang('btn_download')}</a></div>
{else}
	<div>{$lang->lang('not_on_rko')}</div>
{/if}
	<div>{$lang->lang('th_taggers')}: {$song->getVar('ss_taggers')}</div>
	<div>{$lang->lang('th_lyrics')}: {$song->getVar('ss_lyrics')}</div>
{if $playing}
	<div id="st_left">{$lang->lang('seconds_left')}: {$left}</div>
{/if}
</div>

{if $song->isTagged()}
<div class="box box_c">
{foreach from=$song->getTags() item=tag}
	<span>{$tag}: {$song->getVotePercent($tag)}%</span>
{/foreach}
</div>
{/if}

<div class="box box_c">
	<div>{button type='generic' url=$song->hrefTag() title=$lang->lang('tag_this_song') text=$lang->lang('tag_this_song')}</div>
	<div>{button type='generic' url=$song->hrefLyrics() title=$lang->lang('add_lyrics_to_song') text=$lang->lang('add_lyrics_to_song')}</div>
</div>
{/if}