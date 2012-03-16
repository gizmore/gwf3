<?php
/**
 * Will send very simple html and plaintext mails.
 * Supports GPG signing and encryption.
 * Uses UTF8 encoding.
 * @TODO: attachments
 * @TODO: Test cc and bcc
 * @TODO: Make use of staff cc
 * @author gizmore
 * */
final class GWF_Mail
{
	const HEADER_NEWLINE = "\n";
	const GPG_PASSPHRASE = ''; #GWF_EMAIL_GPG_SIG_PASS;
	const GPG_FINGERPRINT = ''; #GWF_EMAIL_GPG_SIG;
	
	private $receiver = '';
	private $receiverName = 'Bar';
	private $sender = '';
	private $senderName = 'Foo';
	private $subject = '';
	private $body = '';
	private $attachments = array();
	private $headers = array();
	private $gpgKey = '';
	
	private $allowGPG = true;

	public function __construct() {}
	public function setSender($s) { $this->sender = $s; }
	public function setSenderName($sn) { $this->senderName = $sn; }
	public function setReceiver($r) { $this->receiver = $r; }
	public function setReceiverName($rn) { $this->receiverName = $rn; }
	public function setSubject($s) { $this->subject = $s; }
	public function setBody($b) { $this->body = $b; }
	public function setGPGKey($k) { $this->gpgKey = $k; }
	public function setAllowGPG($bool) { $this->allowGPG = $bool; }
//	public function addAttachment($title, $file) {}
//	public function removeAttachment($title) {}

	public static function sendMailS($sender, $receiver, $subject, $body, $html=false)
	{
		$mail = new self();
		$mail->setSender($sender);
		$mail->setReceiver($receiver);
		$mail->setSubject($subject);
		$mail->setBody($body);

		return false === $html
			? $mail->sendAsText()
			: $mail->sendAsHTML();
	}

	public static function sendDebugMail($subject, $body)
	{
		return self::sendMailS(GWF_BOT_EMAIL, GWF_ADMIN_EMAIL, GWF_SITENAME.$subject, GWF_Debug::getDebugText($body));
	}

	public function nestedHTMLBody()
	{
		$tVars = array(
			'content' => nl2br($this->body),
		);
		return GWF_Template::templateMain('mail.tpl', $tVars);
	}
	
	public function nestedTextBody()
	{
		$body = $this->body;
		#$body = preg_replace('/<[^>]+>([^<]+)<[^>+]>/', '$1', $body);
		$body = preg_replace('/<[^>]+>/', '', $body);
		$body = GWF_HTML::br2nl($body);
		$body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
		return $body;
	}

	/*	public function addHeader($key, $value)
	 {
		$this->headers[$key] = $value;
		}

		public function removeHeader($key)
		{
		unset($this->headers[$key]);
		}*/

	public function sendToUser(GWF_User $user)
	{
		$this->setupGPG($user);
		
		if ($user->isOptionEnabled(GWF_User::EMAIL_TEXT))
		{
			return $this->sendAsText();
		}
		else
		{
			return $this->sendAsHTML();
		}
		
	}
	
	public function sendAsText($cc='', $bcc='')
	{
		return $this->send($cc, $bcc, $this->nestedTextBody(), false);
	}

	public function sendAsHTML($cc='', $bcc='')
	{
		return $this->send($cc, $bcc, $this->nestedHTMLBody(), true);
	}
	
	public function send($cc, $bcc, $message, $html=true)
	{
		
		$headers = '';
			#'From: =?UTF-8?B?'
			#.base64_encode($this->senderName).'?=<'
			#. $this->sender . ">\r\n";

			#$to = '=?UTF-8?B?'.base64_encode($this->receiverName)
			#.'?=<'. $this->receiver.'>' ;
		
		$to = $this->receiver;

		# UTF8 Subject :)
		$subject='=?UTF-8?B?'.base64_encode($this->subject)."?=";

#		if($cc!=''){
#			$cc = explode('<',$cc );
#			$headers .= 'Cc: =?UTF-8?B?'
#			.base64_encode($cc[0]).'?= <'
#			. $cc[1].'>' . "\r\n";
#		}

#			if($bcc!=''){#
#				$bcc = explode('<',$bcc );
#				$headers .= 'Bcc: =?UTF-8?B?'
#				.base64_encode($bcc[0]).'?= <'
#				. $bcc[1].'>' . "\r\n";
#			}

//			$message = $this->nestedHTMLBody();

			$headers .= 'From: '.$this->sender.self::HEADER_NEWLINE;
			# HTML / UTF8
			$contentType= $html ? 'text/html' : 'text/plain';
			
			$headers .= 
			
		"Content-Type: $contentType; charset=utf-8".self::HEADER_NEWLINE
#		. ""# format=flowed\n"
		. "MIME-Version: 1.0".self::HEADER_NEWLINE
		. "Content-Transfer-Encoding: 8bit".self::HEADER_NEWLINE
		. "X-Mailer: PHP";

		$encrypted = $this->encrypt($message);
		
		if (GWF_DEBUG_EMAIL & 16)
		{
			printf('<h1>Local EMail:</h1><pre>%s<br/>%s</pre>', GWF_HTML::display($this->subject), $message);
			return true;
		}
		else
		{
			return @mail($to, $subject, $encrypted, $headers, '-r ' . $this->sender);
		}
	}
	
	private function setupGPG(GWF_User $user)
	{
		if ($this->allowGPG)
		{
			if (function_exists('gnupg_init'))
			{
				if (false !== ($fingerprint = GWF_PublicKey::getFingerprintForUser($user)))
				{
					$this->setGPGKey($fingerprint);
				}
			}
		}
	}
	
	private function encrypt($message)
	{
		if ($this->gpgKey === '' && self::GPG_FINGERPRINT === '')
		{
			return $message;
		}
		
		if (false === function_exists('gnupg_init'))
		{
			return $message.PHP_EOL.'GnuPG Error: gnupg extension is missing.';
		}
		
		if (false === ($gpg = gnupg_init()))
		{
			return $message.PHP_EOL.'GnuPG Error: gnupg_init() failed.';
		}
		
		if ($this->gpgKey !== '')
		{
			if (false === gnupg_addencryptkey($gpg, $this->gpgKey)))
			{
				return $message.PHP_EOL.'GnuPG Error: gnupg_addencryptkey() failed.';
			}
		}
		
		$signed = false;
//		if (self::GPG_FINGERPRINT !== '') {
//			$sign_key = preg_replace('/[^a-z0-9]/i', '', self::GPG_FINGERPRINT);
//			
//			if (self::GPG_PASSPHRASE==='')
//			{
//				if (false === gnupg_addsignkey($gpg, $sign_key)) {
//					$message .= PHP_EOL.'GnuPG Error: gnupg_addsignkey1() failed.';
//				}
//				else {
//					$signed = true;
//				}
//			}
//			else
//			{
//				if (false === gnupg_addsignkey($gpg, $sign_key, self::GPG_PASSPHRASE)) {
//					$message .= PHP_EOL.'GnuPG Error: gnupg_addsignkey2() failed.';
//				}
//				else {
//					$signed = true;
//				}
//			}
//			
//		}
		
		if ($signed === true)
		{
			if (false === ($back = gnupg_encryptsign($gpg, $message))) {
				return $message.PHP_EOL.'GnuPG Error: gnupg_encryptsign() failed.';
			}
		}
		else
		{
			if (false === ($back = gnupg_encrypt($gpg, $message))) {
				return #$message.PHP_EOL.
					'GnuPG Error: gnupg_encrypt() failed.'.PHP_EOL.'Message has been removed!';
			}
		}
		
		return $back;
	}
}
