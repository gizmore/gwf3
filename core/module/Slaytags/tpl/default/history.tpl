<h1>{$lang->lang('previously_played')}</h1>
{if $page eq 1}
	{box title='Slayzone' text='This is the first known human record of a slaytagging.<br/>The early drawings fill you with deep respect as you can only guess the age.'}
{/if}

{$pagemenu}
{$gwf->Table()->start()}
{$gwf->Table()->displayHeaders1(array(
array(),
array($lang->lang('th_date')),
array($lang->lang('D')),
array($lang->lang('L')),
array($lang->lang('T')),
array("{$lang->lang('th_artist')}{$lang->lang('th_title')}"),
array($lang->lang('th_tags'))
))}
{foreach from=$history item=s}
	{$gwf->Table()->rowStart()}
	{if $is_admin}
		{$gwf->Table()->column({button type='edit' title=$lang->lang('tag_this_song') url=$s->hrefEdit()}, 'ri')}
	{else}
		{$gwf->Table()->column()}
	{/if}
	{$gwf->Table()->column({$s->getVar('sph_date')|date})}
	{if $s->isRKO()}
		{$gwf->Table()->column({button type='download' text='D' title=$lang->lang('download_from_rko') url=$s->hrefRKO()}, 'ce')}
	{else}
		{$gwf->Table()->column()}
	{/if}
	{if $s->hasLyrics()}
		{$gwf->Table()->column({button type='generic' text='L' title=$lang->lang('show_lyrics') url=$s->hrefShowLyrics()}, 'ce')}
	{else}
		{$gwf->Table()->column()}
	{/if}
	{$gwf->Table()->column({button type='generic' text=$s->getVar('ss_taggers') title=$lang->lang('tag_this_song') url=$s->hrefTag()}, 'ce')}
	{$gwf->Table()->column("<a href=\"{$s->hrefTag()}\">{$s->display('ss_artist')}<br/>{$s->display('ss_title')}</a>")}
	{$gwf->Table()->column($s->getVar('ss_tag_cache'))}
	{$gwf->Table()->rowEnd()}
{/foreach}
{$gwf->Table()->end()}
{$pagemenu}
