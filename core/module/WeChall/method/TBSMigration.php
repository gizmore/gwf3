<?php

/**
 * WeChall can validate your TBS account ownership.
 * API to recover/migrate TBS accounts to tbs.wechall.net
 * 
 * @author gizmore
 */
final class WeChall_TBSMigration extends GWF_Method
{
    public function execute()
    {
        GWF_Website::plaintext();
        
        # usernames
        if (!($wc = Common::getRequestString('wc')))
        {
            die('err_param_wc');
        }
        
        if (!($tbs = Common::getRequestString('tbs')))
        {
            die('err_param_tbs');
        }
        
        if (!$site = WC_Site::getByClassName('TBS'))
        {
            die('err_site_tbs');
        }
        
        if (!$token = Common::getRequestString('token'))
        {
            die('err_param_token');
        }
        
        if (!($user = GWF_User::getByName($wc)))
        {
            die('err_wechall_name');
        }
        
        Module_WeChall::instance()->includeClass('WC_RegAt');
        if (!($regat = WC_RegAt::getRegatRow($user->getID(), $site->getID())))
        {
            die('err_not_linked');
        }
        
        if ($tbs !== $regat->getVar('regat_onsitename'))
        {
            die('err_combination');
        }
        
        if (!$user->hasValidMail())
        {
            die('err_no_mail');
        }
        
        $this->sendMail($user, $tbs, $token);
        
        die('msg_mail_sent');
    }

    private function sendMail(GWF_User $user, $tbs, $token)
    {
        $link = sprintf(
            'https://tbs.wechall.net/index.php?mo=TBS&me=Migrate&tbs=%s&wechall=%s&token=%s',
            urlencode($tbs),
            urlencode($user->displayUsername()),
            urlencode($token));
        $body = sprintf("Hello %s,<br/>
<br/>
It seems like you want to migrate your TBS account to tbs.wechall.net<br/>
To complete this, please visit the link below.<br/>
<br/>
%s<br/>
<br/>
Happy Challenging!", $user->displayUsername(), $link);
        $mail = new GWF_Mail();
        $mail->setSender(GWF_BOT_EMAIL);
        $mail->setSenderName("WeChall");
        $mail->setSubject("[TBS][WeChall] - Try out tbs.wechall.net");
        $mail->setBody($body);
        $mail->sendToUser($user);
    }
}
