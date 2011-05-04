{$pagemenu}

{button url=$href_all title=$lang->lang('btn_show_all') text=$lang->lang('btn_show_all')}
{button url=$href_open title=$lang->lang('btn_show_open') text=$lang->lang('btn_show_open')}
{button url=$href_work title=$lang->lang('btn_show_work') text=$lang->lang('btn_show_work')}
{button url=$href_closed title=$lang->lang('btn_show_closed') text=$lang->lang('btn_show_closed')}
{button url=$href_unsolved title=$lang->lang('btn_show_unsolved') text=$lang->lang('btn_show_unsolved')}
{button url=$href_own title=$lang->lang('btn_show_own') text=$lang->lang('btn_show_own')}

{$gwf->Table()->start()}
{$gwf->Table()->displayHeaders1(array(
	array($lang->lang('th_tid'), 'hdt_id', 'DESC'), 
	array($lang->lang('th_prio'), 'hdt_priority', 'DESC'),
	array($lang->lang('th_creator'), 'creator.user_name', 'ASC'),
	array($lang->lang('th_worker'), 'worker.user_name', 'ASC'),
	array($lang->lang('th_title'), 'hdt_title', 'ASC'),
	array($lang->lang('th_status'), 'hdt_status', 'ASC'),
	array({button type='bell' title=$lang->lang('th_unread') url='#'})
), $sort_url)}

{foreach $tickets as $ticket}
{$gwf->Table()->rowStart()}
{$gwf->Table()->column($ticket->displayShowLink($ticket->getID()), 'gwf_num')}
{$gwf->Table()->column($ticket->displayShowLink($ticket->getPriority()), 'gwf_num')}
{$gwf->Table()->column($gwf->User()->displayProfileLinkS($ticket->getVar('creator_name')))}
{$gwf->Table()->column($gwf->User()->displayProfileLinkS($ticket->getVar('worker_name')))}
{$gwf->Table()->column($ticket->displayShowLink($ticket->displayTitle($user)))}
{$gwf->Table()->column($ticket->displayShowLink($ticket->displayStatus()))}
{if $ticket->hasStaffRead()}
{$gwf->Table()->column()}
{else}
{$gwf->Table()->column({button type='bell' title=$lang->lang('th_unread') url='#'})}
{/if}
{$gwf->Table()->rowEnd()}
{/foreach}

{$gwf->Table()->end()}

{$pagemenu}
