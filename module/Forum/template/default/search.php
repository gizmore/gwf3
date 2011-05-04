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
	$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);
	
	$data = array();
	foreach ($tVars['result'] as $post)
	{
		$post instanceof GWF_ForumPost;
		$hrefPost = $post->getShowHREF($tVars['term']);
		$hrefProfile = $post->getUser()->getProfileHREF();
		$data[] = array(
			GWF_HTML::anchor($hrefPost, $post->displayPostDate()),
			GWF_HTML::anchor($hrefProfile, $post->getUser()->displayUsername()),
			GWF_HTML::anchor($hrefPost, $post->getVar('post_title')),
			$post->getVar('post_thanks'),
			$post->getVar('post_votes_up'),
		);
	}
	
	echo GWF_Table::display2($headers, $data, $tVars['sort_url']);
}
?>