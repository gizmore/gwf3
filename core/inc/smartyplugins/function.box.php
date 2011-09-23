<?php
function smarty_function_box($params, $template)
{
	if (empty($params['content']))
	{
		return '';
	}
	if (empty($params['title']))
	{
		return '<div class="box"><div class="box_c">'.$params['content'].'</div></div>';
	}
	else
	{
		return '<div class="box"><div class="box_t">'.$params['title'].'</div><div class="box_c">'.$params['content'].'</div></div>';
	}
}
?>