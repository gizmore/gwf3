<?php
echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic('ConvertDB', $tVars['href_convert']);
echo GWF_Button::generic('Fix Chall Tags', $tVars['href_chall_cache']);
echo GWF_Button::generic('Fix Chall DB', $tVars['href_fix_challs']);
echo GWF_Button::generic('Fix Site Tags', $tVars['href_sitetags']);
echo GWF_Button::generic('Fix IRC', $tVars['href_fix_irc']);
echo GWF_Button::generic('Recalc Everything', $tVars['href_recalc_all']);
echo GWF_Button::generic('Freeze User', $tVars['href_freeze']);
echo GWF_Button::generic('BIGMail', $tVars['href_siteminmail']);
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;

echo $tVars['form_hardlink'];
?>
