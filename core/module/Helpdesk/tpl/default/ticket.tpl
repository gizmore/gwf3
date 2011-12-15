<h1>Ticket #{$ticket->getID()}</h1>

<div>
	<div>{$lang->lang('th_title')}: {$ticket->displayTitle($user)}</div>
	<div>{$lang->lang('th_creator')}: {$creator->displayProfileLink()}</div>
	<div>{$lang->lang('th_priority')}: {$ticket->getPriority()} {button type='add' url=$href_raise_prio title=$lang->lang('btn_raise_prio')} {button type='sub' url=$href_lower_prio title=$lang->lang('btn_lower_prio')} </div>
	{if $worker===false}
	<div>{$lang->lang('th_worker')}: {button url=$href_work title=$lang->lang('btn_work') text=$lang->lang('btn_work')}</div>
	{else}
	<div>{$lang->lang('th_worker')}: {$worker->displayProfileLink()}</div>
	{/if}
	<div>{$lang->lang('th_status')}: {$ticket->displayStatus()}</div>
	{if !$ticket->isClosed()}
	<div class="gwf_buttons gwf_buttons_outer">{button url=$href_solve title=$lang->lang('btn_close') text=$lang->lang('btn_close')}</div>
	<div class="gwf_buttons gwf_buttons_outer">{button url=$href_unsolve title=$lang->lang('btn_unsolve') text=$lang->lang('btn_unsolve')}</div>
	{/if}
	{if $ticket->isFAQ()}
	<div>{$lang->lang('info_ticket_faq')} {button url=$href_nofaq text=$lang->lang('btn_nofaq') title=$lang->lang('btn_nofaq')}</div>
	{else}
	<div>{$lang->lang('info_ticket_nofaq')} {button url=$href_faq text=$lang->lang('btn_faq') title=$lang->lang('btn_faq')}</div>
	{/if}
	{if $is_admin && $ticket->isFAQ()}
	{if $ticket->isInFAQ()}
	<div>{$lang->lang('info_ticket_infaq')} {button url=$href_noinfaq text=$lang->lang('btn_noinfaq') title=$lang->lang('btn_noinfaq')}</div>
	{else}
	<div>{$lang->lang('info_ticket_noinfaq')} {button url=$href_infaq text=$lang->lang('btn_infaq') title=$lang->lang('btn_infaq')}</div>
	{/if}
	{/if}
</div>

<br/><hr/><br/>

{foreach $messages as $msg}
<div>
	<div>{$msg->displayAuthor()}</div>
	<div>{$msg->displayDate()}</div>
	<div>{$msg->displayMessage()}</div>
	<div class="gwf_buttons gwf_buttons_outer">
	{if $is_admin && $ticket->isInFAQ()}
		{if $msg->isFAQ()}
		{$lang->lang('info_msg_faq')} {button url=$msg->hrefFaq('0') text=$lang->lang('btn_noinfaq') title=$lang->lang('btn_noinfaq')}
		{else}
		{$lang->lang('info_msg_nofaq')} {button url=$msg->hrefFaq('1') text=$lang->lang('btn_infaq') title=$lang->lang('btn_infaq')}
		{/if}
	{/if}
	</div>
</div>
{/foreach}

{button type='reply' url=$href_reply title=$lang->lang('btn_reply')}

{$form}
