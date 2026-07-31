<?php
/**
 * @var array{
 *     'votescore': GWF_VoteScore,
 *     'lang': string,
 *     'module': GWF_Module
 *   } $tVars
 * @var ?GWF_LangTrans $tLang
 */

$vs = $tVars['votescore'];
$min = $vs->getVar('vs_min'); # 1
$max = $vs->getVar('vs_max'); # 5
$range = $max - $min + 1;
$text = $tLang->lang('title_button', array( '%1%'));
echo '<span id="'.sprintf('gwf_vsb_%d', $vs->getVar('vs_id')).'">';
$val = $min;
for ($i = 0; $i < $range; $i++)
{
	$sval = (string)$val;
	printf(
		'<a class="gwf_votebtn" href="#" onclick="%s"><span class="gfw_vote_dot" style="background-color: #%s" title="%s"></span></a>',
		$vs->getOnClick($sval),
		GWF_Color::interpolatBound($min, $max, $sval),
		str_replace('%1%', $sval, $text)
	);
	$val++;
}
echo '</span>';
