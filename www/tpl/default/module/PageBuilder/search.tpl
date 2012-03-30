{$quicksearch}

{$pagemenu}

{GWF_Table::start()}
{GWF_Table::displayHeaders1(array(
array($lang->lang('th_id'), '', 'ASC'),
array($lang->lang('th_title'), '', 'ASC'),
array($lang->lang('translations'), '', 'ASC'),
array($lang->lang('created_on'), '', 'ASC')
), $sort_url)}
{GWF_Table::rowStart()}<td></td><td></td><td>{foreach $languages as $l}{$l->displayFlag()}{/foreach}</td><td></td>{GWF_Table::rowEnd()}
{foreach $pages as $page}
{GWF_Table::rowStart()}
{GWF_Table::column($page['page_id'], 'gwf_num')}
{GWF_Table::column($page['page_title'])}
{GWF_Table::column($page['languages'])}
{GWF_Table::column($page['page_date']|date)}
{GWF_Table::rowEnd()}
{/foreach}
{GWF_Table::end()}

{$pagemenu}
