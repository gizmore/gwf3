<?php
echo $tVars['module']->getUserGroupButtons();
echo $tVars['page_menu'];
echo GWF_Table::start('', 'gwf_avatar_gallery');
$X = $tVars['num_x'];
$i = 0;
$td = 1;
foreach ($tVars['avatars'] as $data)
{
	if ($i%$X === 0) {
		if (($X % 2)===0) {
			$td = 1-$td;
		}
		echo '<tr>';
	}
	
	$td = 1-$td;
	
	$href = GWF_WEB_ROOT.'avatar/gallery/show/'.$data['user_id'];
	$uname = htmlspecialchars($data['user_name']);
	$title = GWF_HTML::lang('alt_avatar', array($uname));
	$src = GWF_WEB_ROOT.'dbimg/avatar/'.$data['user_id'];
	echo sprintf('<td class="gwf_trd_%d"><a href="%s" title="%s"><img src="%s" alt="%s" /><div>%s<br/>%d Hits</div></a></td>', $td, $href, $title, $src, $title, $uname, intval($data['ag_hits'])).PHP_EOL;
	
	if ($i%$X === $X-1) {
		echo '</tr>';
	}
	$i++;
}
echo GWF_Table::end();
echo $tVars['page_menu'];
?>