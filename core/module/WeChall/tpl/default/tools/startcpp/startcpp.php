<?php
$href1 = 'http://www.mingw.org/';
$href2 = 'http://www.codeblocks.org/';
echo GWF_Box::box($tVars['lang2']->lang('box_1_b', array($href1, $href2)), $tVars['lang2']->lang('box_1_t'));

echo GWF_Box::box($tVars['lang2']->lang('box_2_b'), $tVars['lang2']->lang('box_2_t'));

echo GWF_Box::box($tVars['lang2']->lang('box_3_b'), $tVars['lang2']->lang('box_3_t'));

echo GWF_Box::box($tVars['lang2']->lang('box_4_b'), $tVars['lang2']->lang('box_4_t'));

$href1 = 'http://jcatki.no-ip.org:8080/fncpp/Resources#books';
$href2 = 'http://www.relisoft.com/book/web_preface.html';
$href3 = 'http://www.mindview.net/Books/TICPP/ThinkingInCPP2e.html';
$href4 = 'http://www.dinkumware.com/manuals/';
$href5 = 'http://www.cprogramming.com/';
$href6 = 'http://www.highscore.de/';
$href7 = 'http://www.iks.hs-merseburg.de/~kilian/ak_Dateien/ak_lehre_Dateien/2010_SS/Bioinformatik_VL/Lehrmaterial/C++/Kurs%20Volkhard%20Henkel/html/inhalt.html';
echo GWF_Box::box($tVars['lang2']->lang('box_5_b', array($href1, $href2, $href3, $href4, $href5, $href6, $href7)), $tVars['lang2']->lang('box_5_t'));
?>