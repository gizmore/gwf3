{* <div class="content_space"></div> *}
<br/>
<div class="fw ce" id="kt_table">
{$pagemenu}
{$gwf->Table()->start()}
{$gwf->Table()->displayHeaders1(array(
array($lang->lang('th_date'), 'kt_date', 'ASC'),
array($lang->lang('th_tickets'), 'kt_date', 'ASC'),
array($lang->lang('th_prog'), 'kt_prog', 'ASC'),
array($lang->lang('th_city'), 'kt_city', 'ASC'),
array($lang->lang('th_location'), 'kt_location', 'ASC')
), $sort_url)}
{foreach from=$termine item=t}
{$gwf->Table()->rowStart()}
{$gwf->Table()->column("{$t->displayDate()}<br/>{$t->displayTime()}")}
{$gwf->Table()->column($t->displayTickets(), 'col_tickets')}
{$gwf->Table()->column($t->getVar('kt_prog'))}
{$gwf->Table()->column($t->getVar('kt_city'))}
{$gwf->Table()->column($t->getVar('kt_location'))}
{$gwf->Table()->rowEnd()}
{/foreach}
{$gwf->Table()->end()}
{$pagemenu}
</div>

{if $user->isAdmin()}
<div class="gwf_buttons gwf_buttons_outer">
	{button url=$href_admin text=$lang->lang('btn_add')}
</div>
{/if}
