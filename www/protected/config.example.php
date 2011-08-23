<?php
#######################
### Error reporting ###
#######################
ini_set('display_errors', 1);
error_reporting(0xffffffff);

############
### Main ###
############
define('GWF_DOMAIN', 'localhost'); # Example: 'www.foobar.com'.
define('GWF_SITENAME', 'GWF install script'); # Your Site`s name. htmlspecialchars() it yourself.

################
### Defaults ###
################
define('GWF_DEFAULT_DOCTYPE', 'html5');
define('GWF_DEFAULT_URL', 'about_gwf'); # 1st visit URL. Example: 'home'.
define('GWF_DEFAULT_LANG', 'en'); # Fallback language. Should be 'en'.
define('GWF_DEFAULT_MODULE', 'GWF'); # 1st visit module. Example: 'MyModule'.
define('GWF_DEFAULT_METHOD', 'About'); # 1st visit method. Example: 'Home'.
define('GWF_DEFAULT_DESIGN', 'default'); # Default design. Example: 'default'.
define('GWF_ICON_SET', 'default'); # Default design. Example: 'default'.

define('GWF_SMARTY_PATH', GWF_CORE_PATH.'inc/3p/smarty/Smarty.class.php'); # Path to Smarty.class.php. Smarty replaced the GWF template engine and has to be available.
define('GWF_SMARTY_TPL_DIR', GWF_PATH.'extra/temp/smarty_cache/tpl');
define('GWF_SMARTY_COMPILE_DIR', GWF_PATH.'extra/temp/smarty_cache/tplc');
define('GWF_SMARTY_CACHE_DIR', GWF_PATH.'extra/temp/smarty_cache/cache');
define('GWF_SMARTY_CONFIG_DIR', GWF_PATH.'extra/temp/smarty_cache/cfg');
define('GWF_SMARTY_PLUGINS_DIR', GWF_CORE_PATH.'inc/smartyplugins');

################
### Language ###
################
define('GWF_LANG_ADMIN', 'en'); # Admins language. Should be 'en'.
define('GWF_SUPPORTED_LANGS', 'en;de;fr;it;pl;hu;es;bs;et;fi;ur;tr;sq;nl;ru;cs;sr'); # Separate 2 char ISO codes by semicolon. Currently (partially) Supported: en;de;fr;it;pl;hu;es;bs;et;fi;ur;tr;sq;nl;ru;cs;sr

###############
### Various ###
###############
define('GWF_ONLINE_TIMEOUT', 60); # A request will mark you online for N seconds.
define('GWF_CRONJOB_BY_WEB', 0); # Chance in permille to trigger cronjob by www clients (0-1000)
define('GWF_CAPTCHA_COLOR_BG', 'FFFFFF'); # Captcha background color. 6 hex digits. Example: ffffff
define('GWF_USER_STACKTRACE', true); # Show stacktrace to the user on error? Example: true.

################
### Database ###
################
define('GWF_SECRET_SALT', ''); # May not be changed after install!
define('GWF_CHMOD', 0700); # CHMOD mask for file creation. 0700 for mpm-itk env. 0777 in worst case.
define('GWF_DB_HOST', 'localhost'); # Database host. Usually localhost.
define('GWF_DB_USER', ''); # Database username. Example: 'some_sql_username'.
define('GWF_DB_PASSWORD', ''); # Database password.
define('GWF_DB_DATABASE', 'GWF'); # Database db-name.
define('GWF_DB_TYPE', 'mysql'); # Database type. Currently only 'mysql' is supported.
define('GWF_DB_ENGINE', 'innoDB'); # Default database table type. Either 'innoDB' or 'myIsam'.
define('GWF_TABLE_PREFIX', 'gwf3_'); # Database table prefix. Example: 'gwf3_'.

###############
### Session ###
###############
define('GWF_SESS_NAME', 'GWF'); # Cookie Prefix. Example: 'GWF'.
define('GWF_SESS_LIFETIME', 14400); # Session lifetime in seconds.
define('GWF_SESS_PER_USER', 1); # Number of allowed simultanous sessions per user. Example: 1

##########
### IP ###
##########
define('GWF_IP_QUICK', 'hash_32_1'); # Hashed IP Duplicates. See inc/util/GWF_IP6.php
define('GWF_IP_EXACT', 'bin_32_128'); # Complete IP storage. See inc/util/GWF_IP6.php

#############
### EMail ###
#############
define('GWF_DEBUG_EMAIL', 15); # Send Mail on errors? 0=NONE, 1=DB ERRORS, 2=PHP_ERRORS, 4=404, 8=403, 16=MailToScreen)
define('GWF_BOT_EMAIL', ''); # Robot sender email. Example: robot@www.site.com.
define('GWF_ADMIN_EMAIL', ''); # Hardcoded admin mail. Example: admin@www.site.com.
define('GWF_SUPPORT_EMAIL', ''); # Support email. Example: support@www.site.com.
define('GWF_STAFF_EMAILS', ''); # CC staff emails seperated by comma. Example: 'staff@foo.bar,staff2@blub.org'.
