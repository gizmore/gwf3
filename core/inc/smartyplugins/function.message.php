<?php
function smarty_function_message($params, $template)
{
	$title = empty($params['title']) ? '' : $params['title'];
	$message = empty($params['message']) ? '' : $params['message'];
	return GWF_HTML::message($title, $message);
}
?>