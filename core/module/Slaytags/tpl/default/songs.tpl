<h1>List all the songs!</h1>
{if $songs}
	{$pagemenu}
	{$gwf->Table()->start()}
	{$gwf->Table()->displayHeaders1($headers, $sort_url)}
	{foreach from=$songs item=s}
		{$gwf->Table()->rowStart()}
		{$gwf->Table()->column($s->display('ss_artist'), 'ri')}
		{$gwf->Table()->column($s->display('ss_title'))}
		{$gwf->Table()->column($s->displayDuration(), 'gwf_date')}
		{if $s->isRKO()}
			{$gwf->Table()->column({button type='download' text='D' title=$lang->lang('download_from_rko')}, 'ce')}
		{else}
			{$gwf->Table()->column('<b>-</b>')}
		{/if}
		{if $s->hasLyrics()}
			{$gwf->Table()->column({button type='generic' text='L' title=$lang->lang('show_lyrics')}, 'ce')}
		{else}
			{$gwf->Table()->column()}
		{/if}
		{$gwf->Table()->column({button type='generic' text=$s->getVar('ss_taggers') title=$lang->lang('tag_this_song') url=$s->hrefTag()}, 'ce')}
		{$gwf->Table()->column($s->getVar('ss_tag_cache'), 'no_wrap')}
		{$gwf->Table()->rowEnd()}
	{/foreach}
	{$gwf->Table()->end()}
	{$pagemenu}
{else}
	<p>Nothing here, move along!</p>
{/if}
