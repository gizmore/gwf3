{$pagemenu}

<div class="gwf_buttons gwf_buttons_outer">
{button url=$href_published text=$lang->lang('btn_show_published') title=$lang->lang('btn_show_published')}
{button url=$href_disableds text=$lang->lang('btn_show_disableds') title=$lang->lang('btn_show_disableds')}
{button url=$href_locked text=$lang->lang('btn_show_locked') title=$lang->lang('btn_show_locked')}
{button url=$href_revisions text=$lang->lang('btn_show_revisions') title=$lang->lang('btn_show_revisions')}
</div>

{GWF_Table::start()}
{GWF_Table::displayHeaders1(array(
	array($lang->lang('th_id'), 'page_id', 'DESC'),
	array($lang->lang('th_otherid'), 'page_otherid', 'ASC'),
	array($lang->lang('th_lang'), 'page_lang', 'ASC'),
	array($lang->lang('th_title'), 'page_title', 'ASC'),
	array($lang->lang('btn_edit'))
), $sort_url)}

{foreach $pages as $page}
{GWF_Table::rowStart()}
{GWF_Table::column($page->getID(), 'gwf_num')}
{GWF_Table::column($page->getOtherID(), 'gwf_num')}
{GWF_Table::column($page->displayLang())}
{GWF_Table::column({button url=$page->hrefShow() title=$page->display('page_title') text=$page->display('page_title')})}
{GWF_Table::column({button type='edit' url=$page->hrefEdit() title=$lang->lang('btn_edit')})}
{GWF_Table::rowEnd()}
{/foreach}
{GWF_Table::end()}

{$pagemenu}

<div class="gwf_buttons gwf_buttons_outer">
{button url=$href_add text=$lang->lang('btn_add') title=$lang->lang('btn_add')}
</div>