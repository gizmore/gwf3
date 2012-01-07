{* <div class="content_space"></div> *}
<br/>
<div class="fw ce" id="kt_table">
{$pagemenu}
{GWF_Table::start()}
{GWF_Table::displayHeaders1(array(
array($lang->lang('th_date'), 'kt_date', 'ASC'),
array($lang->lang('th_tickets'), 'kt_date', 'ASC'),
array($lang->lang('th_prog'), 'kt_prog', 'ASC'),
array($lang->lang('th_city'), 'kt_city', 'ASC'),
array($lang->lang('th_location'), 'kt_location', 'ASC')
), $sort_url)}
{foreach from=$termine item=t}
{GWF_Table::rowStart()}
{GWF_Table::column("{$t->displayDate()}<br/>{$t->displayTime()}")}
{GWF_Table::column($t->displayTickets(), 'col_tickets')}
{GWF_Table::column($t->getVar('kt_prog'))}
{GWF_Table::column($t->getVar('kt_city'))}
{GWF_Table::column($t->getVar('kt_location'))}
{GWF_Table::rowEnd()}
{/foreach}
{GWF_Table::end()}
{$pagemenu}
</div>

{if $user->isAdmin()}
<div class="gwf_buttons gwf_buttons_outer">
	{button url=$href_admin text=$lang->lang('btn_add')}
</div>
{/if}
