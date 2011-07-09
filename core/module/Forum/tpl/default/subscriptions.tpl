<div class="gwf_board_quicktree">{Module_Forum::getNavTree()}</div>

{* Show settings *}
<div class="box box_c">
{$subscr_intro}
</div>

{* Manual subscribed boards *}
<div class="box box_c">
{$subscr_intro_boards}
{$gwf->Table()->start()}
{$gwf->Table()->displayHeaders1(array(
array('ID'),
array($lang->lang('th_title')),
array($lang->lang('btn_unsubscribe'))
))}
{foreach from=$subscr_boards item=sub}
{$gwf->Table()->rowStart()}
<td>{$sub['board_bid']}</td>
<td><a href={$sub['board_url']|htmlspecialchars}>{$sub['board_title']}</a></td>
<td>{button url=$sub['href_unsub'] text=$lang->lang('btn_unsubscribe')} </td>
{$gwf->Table()->rowEnd()}
{/foreach}
{$gwf->Table()->end()}
</div>

{* Manual subscribed threads *}
<div class="box box_c">
{$subscr_intro_threads}
{$gwf->Table()->start()}
{$gwf->Table()->displayHeaders1(array(
array('ID'),
array($lang->lang('th_title')),
array($lang->lang('btn_unsubscribe'))
))}
{foreach from=$subscr_threads item=sub}
{$gwf->Table()->rowStart()}
<td>{$sub['thread_tid']}</td>
<td><a href={$sub['thread_url']|htmlspecialchars}>{$sub['thread_title']}</a></td>
<td>{button url=$sub['href_unsub'] text=$lang->lang('btn_unsubscribe')} </td>
{$gwf->Table()->rowEnd()}
{/foreach}
{$gwf->Table()->end()}
</div>
