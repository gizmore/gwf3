<h1>{$lang->lang('pt_faq')}</h1>

<div class="gwf_buttons gwf_buttons_outer">
{if $user->isStaff()}
{button url=$href_generate text=$lang->lang('btn_gen_faq') title=$lang->lang('btn_gen_faq')}
{/if}
</div>

{foreach $faq as $q}
<div class="gwf_faq">
	<h3 class="gwf_faq_q" onclick="helpdeskClick({$q['id']})" ]}">{$q['q']}</h3>
	<div id="gwf_faq_a_{$q['id']}" class="gwf_faq_a">
	{foreach $q['a'] as $a}
	<p>{$a}</p>
	{/foreach}
	{if $user->isStaff()}
	<div class="gwf_buttons gwf_buttons_outer">
	{button url=$q['href_edit'] type='edit' title=$lang->lang('btn_edit_faq')}
	</div>
	{/if}
	</div>
</div>
{/foreach}

<div class="gwf_buttons gwf_buttons_outer">
{if $user->isStaff()}
{button url=$href_add text=$lang->lang('btn_add_faq') title=$lang->lang('btn_add_faq')}
{/if}
</div>