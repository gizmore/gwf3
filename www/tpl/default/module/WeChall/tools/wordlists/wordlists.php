<?php

# http://packetstormsecurity.org/Crackers/wordlists/ !RULEZ!

echo sprintf('<h1>%s</h1>', $tVars['lang2']->lang('page_title')).PHP_EOL;
# Wordlists
$wordlists = array(
	"english.zip",
);
$text = $tVars['lang2']->lang('page_info1').'<br/><br/>'.PHP_EOL;
foreach ($wordlists as $i => $filename)
{
	$href = GWF_WEB_ROOT.'tpl/default/module/WeChall/tools/wordlists/files/'.$filename;
	$info = $tVars['lang2']->lang('link_info1_'.$i);
	$text .= sprintf('<div><a href="%s">%s</a></div>', $href, $info).PHP_EOL;
}
echo GWF_Box::box($text);

# TriGraphs
$trigraphs = array(
	'NGfrench.txt' => 'French',
	'NGspanish.txt' => 'Spanish',
);
$text = $tVars['lang2']->lang('page_info2', array(GWF_WEB_ROOT.'profile/mirmo', 'http://www.infomirmo.fr', 'http://www.secretcodebreaker.com/scbsolvr.html')).'<br/><br/>'.PHP_EOL;
foreach ($trigraphs as $filename => $info)
{
	$href = GWF_WEB_ROOT.'tpl/default/module/WeChall/tools/wordlists/files/'.$filename;
	$info = $tVars['lang2']->lang('link_info2', array($info));
	$text .= sprintf('<div><a href="%s">%s</a></div>', $href, $info).PHP_EOL;
}
echo GWF_Box::box($text);

# Links
$links = array(
	'http://www.cotse.com/tools/wordlists.htm',
	'http://packetstormsecurity.org/Crackers/wordlists/',
//	'http://blog.sebastien.raveau.name/2009/03/cracking-passwords-with-wikipedia.html',
);
$text = $tVars['lang2']->lang('page_info3').'<br/><br/>'.PHP_EOL;
foreach ($links as $i => $link)
{
	$info = $tVars['lang2']->lang('link_info3_'.$i);
	$text .= sprintf('<div><a href="%s">%s</a></div>', $link, $info).PHP_EOL;
}
echo GWF_Box::box($text);
?>
