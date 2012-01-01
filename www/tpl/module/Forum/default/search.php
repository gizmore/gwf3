<?php
GWF_Javascript::focusElementByName('term');
echo $tVars['form_quick'];
#echo $tVars['form_adv'];
if (count($tVars['result']) > 0)
{
	echo $tVars['pagemenu'];
	$headers = array(
		array($tLang->lang('th_post_date'), 'post_date', 'DESC'),
		array($tLang->lang('th_user_name'), 'user_name', 'ASC'),
		array($tLang->lang('th_title')),
		array($tLang->lang('th_thanks'), 'post_thanks', 'DESC'),
		array($tLang->lang('th_votes_up'), 'post_votes_up', 'DESC'),
	);
	echo GWF_Table::start();
	echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
	foreach ($tVars['result'] as $post)
	{
		echo GWF_Table::rowStart();
		$post instanceof GWF_ForumPost;
		$hrefPost = $post->getShowHREF($tVars['term']);
		$hrefProfile = $post->getUser()->getProfileHREF();
		echo GWF_Table::column(GWF_HTML::anchor($hrefPost, $post->displayPostDate()));
		echo GWF_Table::column(GWF_HTML::anchor($hrefProfile, $post->getUser()->displayUsername()));
		echo GWF_Table::column(GWF_HTML::anchor($hrefPost, $post->getVar('post_title')));
		echo GWF_Table::column($post->getVar('post_thanks'), 'gwf_num');
		echo GWF_Table::column($post->getVar('post_votes_up'), 'gwf_num');
		echo GWF_Table::rowEnd();
	}
	echo GWF_Table::end();
	echo $tVars['pagemenu'];
}
?>
