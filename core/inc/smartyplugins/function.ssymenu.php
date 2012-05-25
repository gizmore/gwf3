<?php
/**
 * Stupid PHP stuff that is needed in ssy templates.
 * @param array $params
 * @param string $template
 * @return string
 */
function smarty_function_ssymenu($params, $template)
{
	$id = empty($params['id']) ? 0 : $params['id'];
	SSYHTML::$menuID = $id;
	return '';
}
?>
