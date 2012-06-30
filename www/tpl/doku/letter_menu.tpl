<div class="gwf_letter_menu_outer">
<div class="gwf_letter_menu">
{foreach $letters as $letter => $href}
	<a{if $letter === $selected} class="sel"{/if}{$href}>{$letter}</a>

{* gizmore TODO: remove if not needet
	{GWF_HTML::anchor($href, $letter, $sel)}
	{assign var='sel' value="{GWF_HTML::selected($letter === $selected)}"}
	<a{$href}{$sel}>{$letter}</a>
*}
{/foreach}
</div>
</div>
