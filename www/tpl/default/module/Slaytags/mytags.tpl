<h1>Files you have tagged</h1>
{if $songs}
	{$pagemenu}
	{GWF_Table::start()}
	{GWF_Table::displayHeaders1(array(
		array($lang->lang('th_artist'), 'ss_artist'),
		array($lang->lang('th_title'), 'ss_title'),
		array($lang->lang('th_duration'), 'ss_duration'),
		array($lang->lang('D')),
		array($lang->lang('L')),
		array($lang->lang('T'))
	), $sort_url)}
	{foreach from=$songs item=s}
		{GWF_Table::rowStart()}
		{GWF_Table::column($s->display('ss_artist'), 'ri')}
		{GWF_Table::column($s->display('ss_title'))}
		{GWF_Table::column($s->displayDuration(), 'gwf_date')}
		{if $s->isRKO()}
			{GWF_Table::column({button type='download' text='D' title=$lang->lang('download_from_rko')}, 'ce')}
		{else}
			{GWF_Table::column('<b>-</b>')}
		{/if}
		{if $s->hasLyrics()}
			{GWF_Table::column({button type='generic' text='L' title=$lang->lang('show_lyrics')}, 'ce')}
		{else}
			{GWF_Table::column()}
		{/if}
		{GWF_Table::column({button type='generic' text=$s->getVar('ss_taggers') title=$lang->lang('tag_this_song') url=$s->hrefTag()}, 'ce')}
		{GWF_Table::rowEnd()}
	{/foreach}
	{GWF_Table::end()}
	{$pagemenu}
{else}
	<p>You don't have tagged any song yet.</p>
{/if}
