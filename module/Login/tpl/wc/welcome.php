<?php 
if ($tVars['first_time']) {
	$txt = $tLang->lang('welcome', array( $tVars['username']));
} else {
	$txt = $tLang->lang('welcome_back', array( $tVars['username']));
}

echo GWF_Box::box($txt);
if ($tVars['fails'] > 0) {
	echo $tVars['module']->error('err_failures', $tVars['fails']);
}
?>