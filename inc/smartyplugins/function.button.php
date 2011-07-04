<?php
function smarty_function_button($params, $template)
{
	$class = empty($params['class']) ? '' : $params['class'];
	$onclick = empty($params['onclick']) ? '' : ' onclick="'.$params['onclick'].'"';
	$title = empty($params['title']) ? '' : $params['title'];
	$text = empty($params['text']) ? '' : $params['text'];
	$type = empty($params['type']) ? 'generic' : $params['type'];
	$url = empty($params['url']) ? '#' : $params['url'];
	return sprintf('<a class="gwf_button %s" href="%s"%s title="%s"><span class="gwf_btn_%s">%s</span></a>'.PHP_EOL, 
		$class, htmlspecialchars($url), $onclick, $title, $type, $text
	);
}
?>