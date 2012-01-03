<?php
echo WC_HTML::accountButtons();
echo '<h1>'.$tLang->lang('ft_settings').'</h1>'.PHP_EOL;
echo GWF_Box::box($tLang->lang('pi_help'));
echo $tVars['form'];
?>