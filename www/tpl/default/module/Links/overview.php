<h1><?php echo $tVars['tag_title'] . GWF_Button::search($tVars['href_search'], $tLang->lang('btn_search')); ?></h1>
<?php
if ($tVars['new_link_count'] > 0) {
	echo '<div class="gwf_buttons_outer">'.PHP_EOL;
	echo '<div class="gwf_buttons">'.PHP_EOL;
	if (GWF_Session::isLoggedIn()) {
		echo GWF_Button::generic($tLang->lang('btn_mark_read'), $tVars['href_mark_read']);
	}
	echo GWF_Button::bell($tVars['href_new_links'], $tLang->lang('btn_new_links'));
	echo $tLang->lang('info_newlinks', array( $tVars['new_link_count']));
	echo '</div></div>'.PHP_EOL;
}
echo $tVars['cloud'];
echo $tVars['page_menu'];
echo $tVars['links'];
echo $tVars['search'];
echo $tVars['page_menu'];
if ($tVars['may_add_link'])
{
	echo GWF_Button::wrapStart();
	echo GWF_Button::add($tLang->lang('btn_add'), $tVars['href_add']);
	echo GWF_Button::wrapEnd();
}
else
{
	echo GWF_Box::box($tVars['text_add']);
}
?>
