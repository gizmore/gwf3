
{assign var="can_sign" value="{$gb->canSign(GWF_Session::getUser(), $module->cfgAllowGuest())}" nocache}
{assign var="allow_email" value="{$module->cfgAllowEMail()}" nocache}
{assign var="allow_url" value="{$module->cfgAllowURL()}" nocache}
{if $can_moderate}
	{assign var="btn_edit" value="{GWF_Button::options({$href_moderate}, {$tLang->lang('btn_edit_gb')})}" nocache}
{else}
	{assign var="btn_edit" value="" nocache}
{/if}

<h1>{$btn_edit}{$gb->displayTitle()}</h1>
<h2>{$gb->displayDescr()}</h2>

{$page_menu}

{foreach ($entries as $e)}
	{include file='_entry.tpl'}
{/foreach}

{$page_menu}

{if $can_sign}
<div class="gwf_buttons_outer gwf_buttons">
{GWF_Button::reply($href_sign, $lang->lang('btn_sign', array( $gb->displayTitle())))}
</div>
{/if}