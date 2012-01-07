<div class="box box_c">
{if $has_tagged}
{$lang->lang('you_tagged')}
{else}
{$lang->lang('you_not_tagged')}
{/if}
</div>

<div>
	{include file="tpl/default/module/Slaytags/songbox.tpl" song=$song playing=false left=-1}
</div>

{$form}

<div class="box box_c">
{button type='generic' url=$href_add_tag text=$lang->lang('btn_add_tag') title=$lang->lang('btn_add_tag')}
</div>