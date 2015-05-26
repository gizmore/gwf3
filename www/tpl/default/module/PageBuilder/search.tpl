{$quicksearch}

{$pagemenu}

{GWF_Table::start()}
{GWF_Table::displayHeaders1(array(
array($lang->lang('th_on'), '', 'ASC'),
array($lang->lang('th_edit'), '', 'ASC'),
array($lang->lang('th_title'), '', 'ASC'),
array($lang->lang('translations'), '', 'ASC'),
array($lang->lang('created_on'), '', 'ASC'),
array($lang->lang('created_by'), '', 'ASC')
), $sort_url)}
{GWF_Table::rowStart()}<td></td><td></td><td></td><td>{foreach $languages as $l}{$l->displayFlag()}{/foreach}</td><td></td><td></td>{GWF_Table::rowEnd()}
{foreach $pages as $page}
{GWF_Table::rowStart()}
{if ($page['page_options']&32768)==0}
{GWF_Table::column('+')}
{else}
{GWF_Table::column('-')}
{/if}
{if $page['canedit']}
{GWF_Table::column('+')}
{else}
{GWF_Table::column('-')}
{/if}
{GWF_Table::column("<a href=\"/page/{$page['page_url']}\">"|cat:{$page['page_title']}|cat:"</a>")}
{GWF_Table::column($page['languages'])}
{GWF_Table::column($page['page_date']|date)}
{if $page['page_author']==='0'}
{GWF_Table::column({$page['page_author_name']|htmlspecialchars})}
{else}
{GWF_Table::column("<a href=\"/profile/{$page['page_author_name']|htmlspecialchars}\">"|cat:{$page['page_author_name']}|cat:"</a>")}
{/if}
{GWF_Table::rowEnd()}
{/foreach}
{GWF_Table::end()}

{$pagemenu}
