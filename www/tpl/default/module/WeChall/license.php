<?php $l = $tVars['license']; ?>
<h1><?php echo $l->lang('pt_license'); ?></h1>
<?php
$link1 = 'https://github.com/gizmore/gwf3';
$link2 = $link1;
$link3 = 'https://github.com/gizmore/gwf3/commits/master';
$items = $l->lang('wc_license');
foreach ($items as $head => $text)
{
	$text = $l->langA('wc_license', $head, array($link1, $link2, $link3));
	echo GWF_Box::box($text, $head);
}
