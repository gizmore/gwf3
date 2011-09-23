<?php
function smarty_function_error($params, $template)
{
	$title = empty($params['title']) ? '' : $params['title'];
	$message = empty($params['message']) ? '' : $params['message'];
	return GWF_HTML::error($title, $message);
}
?>