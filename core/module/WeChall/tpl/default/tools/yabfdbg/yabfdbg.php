<h1>YaBfDbg</h1>
<?php
$href1 = GWF_WEB_ROOT.'applet/yabfdbg.zip';
$href2 = GWF_WEB_ROOT.'applet/yabfdbg.tar.bz2';
echo GWF_Box::box($tVars['lang2']->lang('info_box_1', array($href1, $href2)), 'YaBfDbg');
echo GWF_Box::box($tVars['lang2']->lang('info_box_2'), $tVars['lang2']->lang('features'));
?>