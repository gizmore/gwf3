<h1>{$lang->lang('pt_helpdesk')}</h1>
<div class="gwf_buttons">
{button type='generic' text=$lang->lang('btn_new_ticket') url=$href_new_ticket}
{button type='generic' text=$lang->lang('btn_my_tickets') url=$href_my_tickets}{$ticketcount}
{if $user->isAdmin() || $user->isStaff()}
{button type='generic' text=$lang->lang('btn_staffdesk') url=$href_staffdesk}{$stafftickets}
{/if}
{button type='generic' text=$lang->lang('btn_show_faq') url=$href_faq}
</div>
{box content=$lang->lang('pi_helpdesk')}