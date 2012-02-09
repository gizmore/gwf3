<?php
echo '<div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic($tLang->lang('btn_fix_counters'), $tVars['href_fix_counters']);
echo GWF_Button::generic($tLang->lang('btn_cleanup'), $tVars['href_cleanup']);
echo '</div>'.PHP_EOL;


if (count($tVars['posts_mod']) > 0)
{
	echo sprintf('<h1>%s</h1>', $tLang->lang('th_posts_to_mod'));
	
	echo $tVars['page_menu_mod'];
	
	$headers = array(
		array($tLang->lang('th_user_name'), 'user_name'),
		array($tLang->lang('th_post_date'), 'post_date'),
		array($tLang->lang('th_message'), 'post_message'),
		array($tLang->lang('th_approve')),
		array($tLang->lang('th_delete')),
	);
	echo GWF_Table::start();
	echo GWF_Table::displayHeaders1($headers, $tVars['sort_url_mod'], '', '', 'mby', 'mdir');
	
	$txt_yes = $tLang->lang('th_approve');
	$txt_no = $tLang->lang('th_delete');
	
	foreach ($tVars['posts_mod'] as $post)
	{
		$post instanceof GWF_ForumPost;
		$thread = $post->getThread();
		if ($thread->isInModeration()) {
			$token = $thread->getToken();
			$tid = $thread->getID();
			$href_approve = GWF_WEB_ROOT.'index.php?mo=Forum&me=Moderate&yes_thread='.$tid.'&token='.$token;
			$href_delete = GWF_WEB_ROOT.'index.php?mo=Forum&me=Moderate&no_thread='.$tid.'&token='.$token;
		} else {
			$token = $post->getToken();
			$pid = $post->getID();
			$href_approve = GWF_WEB_ROOT.'index.php?mo=Forum&me=Moderate&yes_post='.$pid.'&token='.$token;
			$href_delete = GWF_WEB_ROOT.'index.php?mo=Forum&me=Moderate&no_post='.$pid.'&token='.$token;
		}
		
		echo GWF_Table::rowStart();
		echo sprintf('<td>%s</td>', $post->getUser(true)->displayUsername());
		echo sprintf('<td>%s</td>', $post->displayPostDate());
		echo sprintf('<td>%s</td>', Common::stripMessage($post->getVar('post_message'), 50, '[..]'));
		echo sprintf('<td>%s</td>', GWF_Button::generic($txt_yes, $href_approve));
		echo sprintf('<td>%s</td>', GWF_Button::generic($txt_no, $href_delete));
		echo GWF_Table::rowEnd();
	}
	
	echo GWF_Table::end();
}

?>