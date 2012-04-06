<?php
$back = '';
foreach ($tVars['tags'] as $tag)
{
	$back .= sprintf('<a href="%s">%s&nbsp;(%d)</a>'.PHP_EOL, $tag->hrefOverview(), $tag->displayName(), $tag->getCount());
}
echo GWF_HTML::div($back, 'gwf_tags_outer gwf_tags');
?>