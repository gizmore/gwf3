<?php

final class WeChall_ChatLounge extends GWF_Method
{
    public function getHTAccess()
    {
        return
            'RewriteRule ^lounge/?$ /index.php?mo=WeChall&me=ChatLounge' . PHP_EOL;
    }

    public function execute()
    {
        GWF_Website::setPageTitle('WeChall Chat');
        GWF_Website::setMetaTags('WeChall, Contact, Chat, IRC, Web-IRC, Webchat');
        $filename = 'chat_lounge.php';
        $tVars = array(

        );
        return $this->module->templatePHP($filename, $tVars);
    }
}
