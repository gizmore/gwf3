<?php
foreach ($tVars['about']->lang('about_08') as $who => $about)
{
	echo GWF_Box::box($about, $who);
}
?>
