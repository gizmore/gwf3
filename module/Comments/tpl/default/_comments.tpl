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
			{if $c->isVisible()}
			{button type="delete" url=$c->hrefHide() title=$lang->lang('btn_hide')}
			{else}
			{button type="add" url=$c->hrefShow() title=$lang->lang('btn_show')}
			{/if}
			{button type="edit" url=$c->hrefEdit() title=$lang->lang('btn_edit')}
		</div>
		{/if}
	</div>
</div>
{/foreach}
