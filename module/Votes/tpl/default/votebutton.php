<?php
$vs = $tVars['votescore']; $vs instanceof GWF_VoteScore;
$min = $vs->getVar('vs_min'); # 1
$max = $vs->getVar('vs_max'); # 5
$range = $max - $min + 1;
$text = $tLang->lang('title_button', array( '%1%'));
echo '<span id="'.sprintf('gwf_vsb_%d', $vs->getVar('vs_id')).'">';
$val = $min;
for ($i = 0; $i < $range; $i++)
{
	$sval = (string)$val;
	echo sprintf('<a class="gwf_votebtn" href="%s" onclick="%s"><img src="%s" alt="%s" title="%s" /></a>', '#', $vs->getOnClick($sval), $vs->hrefButton($sval), "[$sval]", str_replace('%1%', $sval, $text));
	$val++;
}
echo '</span>';
?>
