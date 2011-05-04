<?php

echo sprintf('<h1>%s</h1>', $tLang->lang('pt_about'));

echo sprintf('<p>%s</p>', $tLang->lang('about'));

echo sprintf('<h2>%s</h2>', $tLang->lang('faq_info'));

echo '<div>';
for ($i = 1; $i <= 7; $i++)
{
	printf('<p class="ptfaqq">%s</p>', $tLang->lang('faqq_'.$i)).PHP_EOL;
	printf('<p class="ptfaqa">%s</p>', $tLang->lang('faqa_'.$i)).PHP_EOL;
}
echo '</div>';

?>