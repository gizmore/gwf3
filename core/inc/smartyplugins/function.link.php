<?php
/**
 * A simple HTML link.
 * {link text="" url="" title="" class="" id="" onclick="" pre="" post=""}
 */
function smarty_function_link($params, $template)
{
	$class = empty($params['class']) ? '' : ' class="'.$params['class'].'"';
	$id = empty($params['id']) ? '' : ' id="'.$params['id'].'"';
	$onclick = empty($params['onclick']) ? '' : ' onclick="'.$params['onclick'].'"';
	$title = empty($params['title']) ? '' : ' title="'.$params['title'].'"';
	$text = empty($params['text']) ? '' : $params['text'];
	$pre = empty($params['pre']) ? '' : $params['pre'];
	$post = empty($params['post']) ? '' : $params['post'];
	$url = empty($params['url']) ? '#' : htmlspecialchars($params['url']);
	
	return sprintf('%s<a href="%s"%s%s%s%s>%s</a>%s', $pre, $url, $title, $class, $id, $onclick, $text, $post);
}
