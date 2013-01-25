<?php
echo GWF_Button::wrapStart();
echo GWF_Button::generic('Site', $tVars['href_site']);
echo GWF_Button::generic('Descr', $tVars['href_descr']);
echo GWF_Button::generic('Boxes', $tVars['href_boxes']);
echo GWF_Button::wrapEnd();

echo $tVars['form'];
?>