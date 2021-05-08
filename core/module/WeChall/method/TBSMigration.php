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
        
        if (!$site = WC_Site::getByClassName('TBS'))
        {
            die('TBS is not listed on wechall');
        }
        
        if (!($wc = Common::getRequestString('wc')))
        {
            die('Missing parameter: wc');
        }
        
        if (!($tbs = Common::getRequestString('tbs')))
        {
            die('Missing parameter: tbs');
        }
        
        if (!($token = Common::getRequestString('token')))
        {
            die('Missing parameter: token');
        }
        
        if (!($email = Common::getRequestString('email')))
        {
            die('Missing parameter: email');
        }
        
        if (!$xauth = Common::getRequestString('xauth'))
        {
            die('Missing parameter: xauth');
        }
        
        if (!($user = GWF_User::getByName($wc)))
        {
            die('The wechall user is unknown');
        }
        
        # Protect below here
        if ($xauth !== $site->getVar('site_xauthkey'))
        {
            die('The xauth token is invalid.');
        }
        
        Module_WeChall::instance()->includeClass('WC_RegAt');
        if (!($regat = WC_RegAt::getRegatRow($user->getID(), $site->getID())))
        {
            die("{$wc} is not linked to TBS");
        }
        
        if (!$user->hasValidMail())
        {
            die('User has no email');
        }
        
        if ($tbs !== $regat->getVar('regat_onsitename'))
        {
            die('User has a different TBS name.');
        }
        
        if ($user->getValidMail() !== $email)
        {
            die('User has a different email.');
        }
        
        $this->sendMail($user, $tbs, $token);
        
        $url = $this->getMigrationURL($user, $tbs, $token);
        
        die('msg_mail_sent');
    }
    
    private function getMigrationURL(GWF_User $user, $tbs, $token)
    {
        $host = Common::getRequestString('host', 'https://tbs.wechall.net');
        $link = sprintf(
            $host . '/index.php?mo=TBS&me=Migrate&tbs=%s&wechall=%s&email=%s&token=%s',
            urlencode($tbs),
            urlencode($user->displayUsername()),
            urlencode($user->getValidMail()),
            urlencode($token));
        return $link;
    }

    private function sendMail(GWF_User $user, $tbs, $token)
    {
        $link = $this->getMigrationURL($user, $tbs, $token);
        $body = sprintf("Hello %s,<br/>
<br/>
It seems like you want to migrate your TBS account to tbs.wechall.net<br/>
To initiate this, please visit the link below.<br/>
<br/>
%s<br/>
<br/>
Happy Challenging!", $user->displayUsername(), $link);
        $mail = new GWF_Mail();
        $mail->setSender(GWF_BOT_EMAIL);
        $mail->setSenderName("WeChall");
        $mail->setReceiver($user->getValidMail());
        $mail->setReceiverName($user->displayUsername());
        $mail->setSubject("[TBS][WeChall] - Try out tbs.wechall.net");
        $mail->setBody($body);
        $mail->sendToUser($user);
    }
    
}
