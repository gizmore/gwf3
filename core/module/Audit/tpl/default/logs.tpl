{$pagemenu}

{GWF_Table::start()}

{GWF_Table::displayHeaders1(array(
array('ID'),
array($lang->lang('th_eusername'), 'al_eusername'),
array($lang->lang('th_username'), 'al_username'),
array($lang->lang('th_logsize'), 'size', 'DESC'),
array($lang->lang('th_time_start'), 'al_time_start'),
array($lang->lang('th_time_rand'), 'al_time_end'),
array($lang->lang('th_rand'), 'al_rand'),
array('S'),
array('T')
), $sort_url)}

{foreach from=$logs item=log}
{GWF_Table::rowStart()}
{GWF_Table::column($log[0])}
{GWF_Table::column($log[1])}
{GWF_Table::column($log[2])}
{GWF_Table::column($log[6]|filesize, 'ri')}
{GWF_Table::column("<a href=\"{$root}warplay/{$log[1]|urlencode}_{$log[2]|urlencode}_{$log[0]}_{$log[5]}.html\"> {$log[3]|timestamp}", 'gwf_date')}
{if !$log[4]}
{GWF_Table::column('')}
{else}
{GWF_Table::column({$log[4]|timestamp}, 'gwf_date')}
{/if}

{GWF_Table::column($log[5], 'mono')}
{GWF_Table::column("<a href=\"{$root}rawscript/{$log[7]}.log\">S</a>")}
{GWF_Table::column("<a href=\"{$root}rawscript/{$log[8]}.log\">T</a>")}

{GWF_Table::rowEnd()}
{/foreach}

{GWF_Table::end()}

{$pagemenu}
