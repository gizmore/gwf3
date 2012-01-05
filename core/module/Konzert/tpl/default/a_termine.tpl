{$pagemenu}

{$gwf->Table()->start()}

{$gwf->Table()->displayHeaders1(array(
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
{$gwf->Table()->rowStart()}
{$gwf->Table()->column({button type='edit' url=$t->hrefEdit()})}
{$gwf->Table()->column($t->getID())}
{$gwf->Table()->column($t->displayDate())}
{$gwf->Table()->column($t->displayTime())}
{$gwf->Table()->column($t->display('kt_prog'))}
{$gwf->Table()->column($t->display('kt_city'))}
{$gwf->Table()->column($t->display('kt_location'))}
{$gwf->Table()->column($t->displayTickets())}
{$gwf->Table()->rowEnd()}
{/foreach}

{$gwf->Table()->end()}

{$pagemenu}

<div class="gwf_buttons gwf_buttons_outer">
	{$add_button}
</div>