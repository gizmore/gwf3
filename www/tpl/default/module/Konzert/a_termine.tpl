{$pagemenu}

{GWF_Table::start()}

{GWF_Table::displayHeaders1(array(
array(),
array('ID', 'kt_id', 'ASC'),
array($lang->lang('th_date'), 'kt_date', 'ASC'),
array($lang->lang('th_time'), 'kt_time', 'ASC'),
array($lang->lang('th_prog'), 'kt_prog', 'ASC'),
array($lang->lang('th_city'), 'kt_city', 'ASC'),
array($lang->lang('th_location'), 'kt_location', 'ASC'),
array($lang->lang('th_tickets'))
), $sort_url)}

{foreach from=$termine item=t}
{GWF_Table::rowStart()}
{GWF_Table::column({button type='edit' url=$t->hrefEdit()})}
{GWF_Table::column($t->getID())}
{GWF_Table::column($t->displayDate())}
{GWF_Table::column($t->displayTime())}
{GWF_Table::column($t->display('kt_prog'))}
{GWF_Table::column($t->display('kt_city'))}
{GWF_Table::column($t->display('kt_location'))}
{GWF_Table::column($t->displayTickets())}
{GWF_Table::rowEnd()}
{/foreach}

{GWF_Table::end()}

{$pagemenu}

<div class="gwf_buttons gwf_buttons_outer">
	{$add_button}
</div>