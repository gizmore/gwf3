{$quicksearch}

{$pagemenu}

{GWF_Table::start()}
{GWF_Table::displayHeaders1(array(
array($lang->lang('th_quot_id'), 'quot_id', 'ASC'),
array($lang->lang('th_quot_text'), 'quot_text', 'ASC'),
array($lang->lang('th_quot_username'), 'quot_username', 'ASC')
), $sort_url)}
{foreach $quotes as $quote}
{GWF_Table::rowStart()}
{GWF_Table::column($quote['quot_id'], 'gwf_num')}
{GWF_Table::column($quote['quot_text']|htmlspecialchars)}
{GWF_Table::column($quote['quot_username']|htmlspecialchars)}
{GWF_Table::rowEnd()}
{/foreach}
{GWF_Table::end()}

{$pagemenu}
