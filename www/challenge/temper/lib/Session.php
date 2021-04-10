<?php
require 'AES.php';

/**
 * AES-Cookie driven Session handler.
 * @author gizmore
 */
class Session
{
    const DUMMY_COOKIE_CONTENT = 'GDO_like_16_byte';
    
    private static $INSTANCE;
    private static $STARTED = false;
    
    private static $COOKIE_NAME = 'tempering';
    private static $COOKIE_DOMAIN = 'www.wechall.net';
    private static $COOKIE_JS = false;
    private static $COOKIE_HTTPS = false;
    private static $COOKIE_SECONDS = 72600;
    
    private $cookieData = array();
    private $cookieChanged = false;
    
    /**
     * @return self
     */
    public static function instance()
    {
        if ( (!self::$INSTANCE) && (!self::$STARTED) )
        {
            self::$INSTANCE = self::start();
            self::$STARTED = true; # only one try
        }
        return self::$INSTANCE;
    }

    public static function reset()
    {
        self::$INSTANCE->setDummyCookie();
        self::$INSTANCE = null;
    }

    public static function init($cookieName='GDO6', $domain='localhost', $seconds=-1, $httpOnly=true, $https = false)
    {
        self::$COOKIE_NAME = $cookieName;
        self::$COOKIE_DOMAIN = $domain;
        self::$COOKIE_SECONDS = $seconds;
        self::$COOKIE_JS = !$httpOnly;
        self::$COOKIE_HTTPS = $https;
    }
    
    ######################
    ### Get/Set/Remove ###
    ######################
    public static function get($key, $initial=null)
    {
        $session = self::instance();
        $data = $session ? $session->cookieData : [];
        return isset($data[$key]) ? $data[$key] : $initial;
    }
    
    public static function set($key, $value)
    {
        if ($session = self::instance())
        {
            if (@$session->cookieData[$key] !== $value)
            {
                $session->cookieChanged = true;
                $session->cookieData[$key] = $value;
            }
        }
    }
    
    public static function remove($key)
    {
        if ($session = self::instance())
        {
            if (isset($session->cookieData[$key]))
            {
                $session->cookieChanged = true;
                unset($session->cookieData[$key]);
            }
        }
    }
    
    public static function commit()
    {
        if (self::$INSTANCE)
        {
            self::$INSTANCE->setCookie();
        }
    }
    
    public static function getCookieValue()
    {
        return isset($_COOKIE[self::$COOKIE_NAME]) ?
            (string)$_COOKIE[self::$COOKIE_NAME] :
            null;
    }
    
    /**
     * Start and get user session
     * @param string $cookieval
     * @param string $cookieip
     * @return self
     */
    private static function start($cookieValue=true, $cookieIP=true)
    {
        # Parse cookie value
        if ($cookieValue === true)
        {
            if (!isset($_COOKIE[self::$COOKIE_NAME]))
            {
                self::setDummyCookie();
                return false;
            }
            $cookieValue = (string)$_COOKIE[self::$COOKIE_NAME];
        }
        
        # Special first cookie
        if ($cookieValue === self::DUMMY_COOKIE_CONTENT)
        {
            $session = self::createSession($cookieIP);
        }
        # Try to reload
        elseif ($session = self::reloadCookie($cookieValue, $cookieIP))
        {
            if ( (!$session->ipCheck()) ||
                (!$session->timeCheck()) )
            {
                self::setDummyCookie();
                return false;
            }
        }
        # Set special first dummy cookie
        else
        {
            self::setDummyCookie();
            return false;
        }
        
        return $session;
    }
    
    public static function reloadCookie($cookieValue)
    {
        if ($decrypted = AES::decrypt($cookieValue, TEMPER_SALT))
        {
            if ($decoded = zlib_decode($decrypted))
            {
                $sess = new self();
                if ($sess->cookieData = json_decode(rtrim($decoded, "\x00"), true))
                {
                    self::$INSTANCE = $sess;
                    return $sess;
                }
                else
                {
                    self::setDummyCookie();
                }
            }
        }
        return false;
    }
    
    public function ipCheck()
    {
        if ($ip = @$this->cookieData['lock_ip'])
        {
            return $ip === @$_SERVER['REMOTE_ADDR'];
        }
        return true;
    }
    
    public function timeCheck()
    {
        if ($time = self::get('sess_time', time()))
        {
            if ( ($time + self::$COOKIE_SECONDS) < time())
            {
                return false;
            }
        }
        return true;
    }
    
    private function setCookie()
    {
        if ($this->cookieChanged)
        {
            if (!setcookie(self::$COOKIE_NAME,
                $this->cookieContent(),
                time() + self::$COOKIE_SECONDS,
                '/',
                self::$COOKIE_DOMAIN,
                self::cookieSecure(),
                !self::$COOKIE_JS))
            {
                die('ERROR SETTING COOKIE!');
            }
            $this->cookieChanged = false;
        }
    }
    
    public function cookieContent()
    {
        if (!$this->cookieData)
        {
            $this->cookieData = [
                'sess_id' => microtime(true) . rand(1000, 9999),
            ];
        }
        $this->cookieData['sess_time'] = time();
        $json = json_encode($this->cookieData);
        $encoded = zlib_encode($json, ZLIB_ENCODING_GZIP, 9);
        $encrypted = AES::encrypt($encoded, TEMPER_SALT);
        return $encrypted;
    }
    
    private static function cookieSecure()
    {
        return false; # TODO: Evaluate protocoll and OR with setting.
    }
    
    private static function setDummyCookie()
    {
        setcookie(
            self::$COOKIE_NAME,
            self::DUMMY_COOKIE_CONTENT,
            time() + 300,
            '/',
            self::$COOKIE_DOMAIN,
            self::cookieSecure(),
            !self::$COOKIE_JS);
    }
    
    private static function createSession()
    {
        $session = new self();
        $session->cookieChanged = true;
        $session->setCookie();
        return $session;
    }
    
}
