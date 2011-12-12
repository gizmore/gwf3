{$pagemenu}

{$gwf->Table()->start()}

{$gwf->Table()->displayHeaders1(array(
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
{$gwf->Table()->rowStart()}
{$gwf->Table()->column($log[0])}
{$gwf->Table()->column($log[1])}
{$gwf->Table()->column($log[2])}
{$gwf->Table()->column($log[6]|filesize, 'ri')}
{$gwf->Table()->column("<a href=\"{$root}warplay/{$log[1]|urlencode}_{$log[2]|urlencode}_{$log[0]}_{$log[5]}.html\"> {$log[3]|timestamp}", 'gwf_date')}
{if !$log[4]}
{$gwf->Table()->column('')}
{else}
{$gwf->Table()->column({$log[4]|timestamp}, 'gwf_date')}
{/if}

{$gwf->Table()->column($log[5], 'mono')}
{$gwf->Table()->column("<a href=\"{$root}rawscript/{$log[7]}.log\">S</a>")}
{$gwf->Table()->column("<a href=\"{$root}rawscript/{$log[8]}.log\">T</a>")}

{$gwf->Table()->rowEnd()}
{/foreach}

{$gwf->Table()->end()}

{$pagemenu}
