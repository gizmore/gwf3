{$pagemenu}

<div class="gwf_buttons gwf_buttons_outer">
{button url=$href_published text=$lang->lang('btn_show_published') title=$lang->lang('btn_show_published')}
{button url=$href_revisions text=$lang->lang('btn_show_revisions') title=$lang->lang('btn_show_revisions')}
{button url=$href_disableds text=$lang->lang('btn_show_disableds') title=$lang->lang('btn_show_disableds')}
</div>

{$gwf->Table()->start()}
{$gwf->Table()->displayHeaders1(array(
	array($lang->lang('th_id'), 'page_id', 'DESC'),
	array($lang->lang('th_otherid'), 'page_otherid', 'ASC'),
	array($lang->lang('th_lang'), 'page_lang', 'ASC'),
	array($lang->lang('th_title'), 'page_title', 'ASC'),
	array($lang->lang('btn_edit'))
), $sort_url)}

{foreach $pages as $page}
{$gwf->Table()->rowStart()}
{$gwf->Table()->column($page->getID(), 'gwf_num')}
{$gwf->Table()->column($page->getOtherID(), 'gwf_num')}
{$gwf->Table()->column($page->displayLang())}
{$gwf->Table()->column({button url=$page->hrefShow() title=$page->display('page_title') text=$page->display('page_title')})}
{$gwf->Table()->column({button type='edit' url=$page->hrefEdit() title=$lang->lang('btn_edit')})}
{$gwf->Table()->rowEnd()}
{/foreach}
{$gwf->Table()->end()}

{$pagemenu}

<div class="gwf_buttons gwf_buttons_outer">
{button url=$href_add text=$lang->lang('btn_add') title=$lang->lang('btn_add')}
</div>