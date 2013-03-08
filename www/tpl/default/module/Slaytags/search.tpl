{if $no_match}
	{error title='Slaytags' message=$lang->lang('err_no_match')}
	<h1>Quicksearcher</h1>
	<p>{$lang->lang('info_quicksearch')}</p>
	{$form}
{else}
	<h1>Quicksearcher</h1>
	<p>{$lang->lang('info_quicksearch')}</p>
	{$form}
	{if $matches}
		{$pagemenu}
		{GWF_Table::start()}
		{GWF_Table::displayHeaders2($headers, $sort_url)}
		{foreach from=$matches item=s}
			{GWF_Table::rowStart()}
			{* ID *}
			<td>{if $is_admin}{button type='edit' url=$s->hrefEdit()}{/if}</td>
			{* LTDS *}
			<td class="ce">{if $s->hasLyrics()}{button type='generic' text='L' title=$lang->lang('show_lyrics') url=$s->hrefShowLyrics()}{/if}</td>
			<td class="ce">{button type='generic' text=$s->getVar('ss_taggers') title=$lang->lang('tag_this_song') url=$s->hrefTag()}</td>
			<td class="ce">{$s->displayDownloadButton($module)}</td>
			{* Title&Artist *}
			<td colspan="2"><a href="{$s->hrefTag()}">{$s->display('ss_artist')}<br/>{$s->display('ss_title')}</a></td>
			{* Duration *}
			<td class="gwf_date">{$s->displayDuration()}</td>
			<td class="ce">{$s->getVar('ss_bpm')}</td>
			<td class="ce">{$s->displayKey()}</td>
			{* Single tag sort *}
			{if $singletag}<td>{$s->getVar('sst_average')|intpercent}</td>{/if}
			{* Tag Cache *}
			<td>{$s->getVar('ss_tag_cache')}</td>
			{GWF_Table::rowEnd()}
		{/foreach}
		{GWF_Table::end()}
		{$pagemenu}
	{/if}
{/if}
