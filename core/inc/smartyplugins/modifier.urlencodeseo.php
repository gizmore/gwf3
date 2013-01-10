<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */
/**
 * Gizmore urlencode SEO modifier
 *
 * Type:     modifier
 * Name:     date
 * Date:     Mar 22, 2011
 * Purpose:  Replace chars in urls with readable ascii characters.
 * Input:    url to replace
 * Example:  {'HAHA ?!?!'|urlencodeseo}
 * @author   gizmore
 * @param array $params parameters
 * @return urlencoded string
 */
function smarty_modifier_urlencodeseo($url)
{
	return Common::urlencodeSEO($url);
}