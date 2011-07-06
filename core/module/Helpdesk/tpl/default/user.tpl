{$pagemenu}


{$gwf->Table()->start()}
{$gwf->Table()->displayHeaders1(array(
	array($lang->lang('th_tid'), 'hdt_id', 'DESC'), 
	array($lang->lang('th_prio'), 'hdt_priority', 'DESC'),
	array($lang->lang('th_worker'), 'worker.user_name', 'ASC'),
	array($lang->lang('th_title'), 'hdt_title', 'ASC'),
	array($lang->lang('th_status'), 'hdt_status', 'ASC'),
	array({button type='bell' title=$lang->lang('th_unread') url='#'})
), $sort_url)}
{foreach $tickets as $ticket}
{$gwf->Table()->rowStart()}
{$gwf->Table()->column($ticket->displayShowLink($ticket->getID()), 'gwf_num')}
{$gwf->Table()->column($ticket->displayShowLink($ticket->getPriority()), 'gwf_num')}
{$gwf->Table()->column($gwf->User()->displayProfileLinkS($ticket->getVar('worker_name')))}
{$gwf->Table()->column($ticket->displayShowLink($ticket->displayTitle($user)))}
{$gwf->Table()->column($ticket->displayShowLink($ticket->displayStatus()))}
{if $ticket->hasUserRead()}
{$gwf->Table()->column()}
{else}
{$gwf->Table()->column({button type='bell' title=$lang->lang('th_unread') url='#'})}
{/if}
{$gwf->Table()->rowEnd()}
{/foreach}
{$gwf->Table()->end()}

{$pagemenu}
