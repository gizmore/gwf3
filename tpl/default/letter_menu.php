<div class="gwf_letter_menu_outer">
<div class="gwf_letter_menu">
<?php
foreach ($tVars['letters'] as $letter => $href)
{
	$class = $letter === $tVars['selected'] ? ' class="sel"' : '';
	echo sprintf('<a%s%s>%s</a>', $class, $href, $letter);
//	echo GWF_HTML::anchor($href, $letter, $sel);
//	$sel = GWF_HTML::selected($letter === $tVars['selected']);
//	echo sprintf('<a%s%s>%s</a>', $href, $sel, $letter);
}
?>
</div>
</div>