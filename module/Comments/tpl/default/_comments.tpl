{foreach $comments as $c}
<div class="gwf_comment box">
	<div class="gwf_comment_head box_t">
		<div class="gwf_date fr">{$c->displayDate()}</div>
		<div>{$c->displayUser()}</div>
		<div>{$c->displayWWW()}</div>
		<div>{$c->displayEMail()}</div>
	</div>
	<div class="gwf_comment_body box_c">
		{$c->displayMessage()}
	</div>
	<div class="gwf_comment_foot box_f">
		{if $can_mod}
		<div class="gwf_buttons gwf_buttons_outer">
			{button type="edit" url=$c->hrefEdit() text=$lang->lang('btn_edit')}
		</div>
		{/if}
	</div>
</div>
{/foreach}
