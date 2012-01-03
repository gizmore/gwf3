<?php $l = $tVars['license']; ?>
<h1><?php echo $l->lang('pt_license'); ?></h1>
<?php
$link1 = 'http://gwf3.gizmore.org';
$link2 = GWF_WEB_ROOT.'wechall.zip';
$link3 = GWF_WEB_ROOT.'changes.txt';
$items = $l->lang('wc_license');
foreach ($items as $head => $text)
{
	$text = $l->langA('wc_license', $head, array($link1, $link2, $link3));
	echo GWF_Box::box($text, $head);
}
?>
