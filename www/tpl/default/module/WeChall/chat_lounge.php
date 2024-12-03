<?php
$link = sprintf("<a href=\"http://lounge.wechall.net:9000/\" target=_blank>%s</a>", WC_HTML::lang('link_chatlounge'));
echo GWF_Box::box(WC_HTML::lang('info_chatlounge', [$link]), WC_HTML::lang('title_chatlounge'));
