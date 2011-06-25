<h1>{$btn_edit}{$gb->displayTitle()}</h1>
<h2>{$gb->displayDescr()}</h2>

{$page_menu}

{foreach $entries as $e}
	{include file='module/Guestbook/tpl/default/_entry.tpl'}
{/foreach}

{$page_menu}

{if $can_sign}
<div class="gwf_buttons_outer gwf_buttons">
{GWF_Button::reply($href_sign, $lang->lang('btn_sign', array( $gb->displayTitle())))}
</div>
{/if}