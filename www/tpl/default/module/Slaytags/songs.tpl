<h1>List all the songs!</h1>
{if $songs}
	{$pagemenu}
	{GWF_Table::start()}
	{GWF_Table::displayHeaders1($headers, $sort_url)}
	{foreach from=$songs item=s}
		{GWF_Table::rowStart()}
		{GWF_Table::column($s->display('ss_artist'), 'ri')}
		{GWF_Table::column($s->display('ss_title'))}
		{GWF_Table::column($s->displayDuration(), 'gwf_date')}
		{if $is_dj}
			{GWF_Table::column({button type='generic' text=$s->getVar('ss_bpm') title=$lang->lang('edit_this_song') url=$s->hrefEdit()}, 'ce')}
			{GWF_Table::column({button type='generic' text=$s->displayKey() title=$lang->lang('edit_this_song') url=$s->hrefEdit()}, 'ce')}
		{else}
			{GWF_Table::column($s->getVar('ss_bpm'), 'gwf_num')}
			{GWF_Table::column($s->displayKey())}
		{/if}
		{if $s->isRKO()}
			{GWF_Table::column({button type='download' url=$s->hrefRKO() text='D' title=$lang->lang('download_from_rko')}, 'ce')}
		{else}
			{GWF_Table::column('<b>-</b>')}
		{/if}
		{if $s->hasLyrics()}
			{GWF_Table::column({button type='generic' text='L' title=$lang->lang('show_lyrics') url=$s->hrefShowLyrics()}, 'ce')}
		{else}
			{GWF_Table::column()}
		{/if}
		{GWF_Table::column({button type='generic' text=$s->getVar('ss_taggers') title=$lang->lang('tag_this_song') url=$s->hrefTag()}, 'ce')}
		{GWF_Table::column($s->getVar('ss_tag_cache'), 'no_wrap')}
		{GWF_Table::rowEnd()}
	{/foreach}
	{GWF_Table::end()}
	{$pagemenu}
{else}
	<p>Nothing here, move along!</p>
{/if}
