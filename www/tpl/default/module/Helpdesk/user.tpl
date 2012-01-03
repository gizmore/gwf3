{$pagemenu}


{GWF_Table::start()}
{GWF_Table::displayHeaders1(array(
	array($lang->lang('th_tid'), 'hdt_id', 'DESC'), 
	array($lang->lang('th_prio'), 'hdt_priority', 'DESC'),
	array($lang->lang('th_worker'), 'worker.user_name', 'ASC'),
	array($lang->lang('th_title'), 'hdt_title', 'ASC'),
	array($lang->lang('th_status'), 'hdt_status', 'ASC'),
	array({button type='bell' title=$lang->lang('th_unread') url='#'})
), $sort_url)}
{foreach $tickets as $ticket}
{GWF_Table::rowStart()}
{GWF_Table::column($ticket->displayShowLink($ticket->getID()), 'gwf_num')}
{GWF_Table::column($ticket->displayShowLink($ticket->getPriority()), 'gwf_num')}
{GWF_Table::column(GWF_User::displayProfileLinkS($ticket->getVar('worker_name')))}
{GWF_Table::column($ticket->displayShowLink($ticket->displayTitle($user)))}
{GWF_Table::column($ticket->displayShowLink($ticket->displayStatus()))}
{if $ticket->hasUserRead()}
{GWF_Table::column()}
{else}
{GWF_Table::column({button type='bell' title=$lang->lang('th_unread') url='#'})}
{/if}
{GWF_Table::rowEnd()}
{/foreach}
{GWF_Table::end()}

{$pagemenu}
