<?php
/**
 * JUST EXAMPLE
 * MOST PATHES ARE WRONG
 * PATCHING BY HAND IS LAME
 */
#######################
### Error reporting ###
#######################
ini_set('display_errors', 0);
error_reporting(0xffffffff);

###################
### Main Config ###
###################
define('GWF_DOMAIN', 'some.net'); # HOSTNAME?
define('GWF_SITENAME', 'Dog');  # any string: sitename
define('GWF_WEB_ROOT_NO_LANG', '/'); # Website root usually / or rarely /myGWF/
define('GWF_LOG_BITS', 0x7fffffff); # see GWF_Log

#################
### 3rd Party ###
#################
# ADJUST THESE. SMARTY IS INCLUDED IN GWF3
define('GWF_SMARTY_PATH', '/data/_ProjectPDT7/GWF3/core/inc/3p/smarty/Smarty.class.php'); # Path to Smarty.class.php. Smarty replaced the GWF template engine and has to be available.
define('GWF_JPGRAPH_PATH', '/opt/php/jpgraph/jpgraph.php'); # Path to jpgraph.php. JPGraph is a library to draw graphs with php. It is available under the GPL.
define('GWF_GESHI_PATH', '/opt/php/geshi/geshi.php'); # Path to geshi.php. GeSHi is a GPL licensed Syntax highlighter.

##############
### Smarty ###
##############
# ADJUST THESE. SMARTY IS INCLUDED IN GWF3
define('GWF_SMARTY_DIRS', '/data/_ProjectPDT7/GWF3/extra/temp/smarty'); # Path to smarty template directory.
define('GWF_ERRORS_TO_SMARTY', false); # Group all Error and display them in one Box?
define('GWF_MESSAGES_TO_SMARTY', false); # Same as above with success-messages

################
### Defaults ###
################
define('GWF_DEFAULT_URL', 'login'); # Default 1st URL ()
define('GWF_DEFAULT_LANG', 'en'); # Default language should be english
define('GWF_DEFAULT_MODULE', 'Login'); # Default 1st Module ()
define('GWF_DEFAULT_METHOD', 'Form'); # Default 1st Method  ()
define('GWF_DEFAULT_DESIGN', 'default'); # Default Design (default)
define('GWF_DEFAULT_DOCTYPE', 'html5'); # Default Design (default)
define('GWF_ICON_SET', 'default'); # Default Icon-Set. Example: 'default'.

################
### Language ###
################
define('GWF_LANG_ADMIN', 'en'); # Admin language should be english
define('GWF_SUPPORTED_LANGS', 'en;de;fr;it;pl;hu;es;bs;et;fi;ur;tr;sq;nl;ru;cs;sr'); # All supported languages

###############
### Various ###
###############
define('GWF_ONLINE_TIMEOUT', 10); # A request will mark you online for N seconds
define('GWF_CRONJOB_BY_WEB', 0); # chance in permille to trigger www cronjob by client (0-1000)
define('GWF_CAPTCHA_COLOR_BG', 'FFFFFF');
define('GWF_USER_STACKTRACE', true); # Show a stacktrace to the user, if set.
#define('GWF_GOOGLE_API_KEY', ''); # Required for GWF_YouTube

##############################
### Database Configuration ###
##############################
define('GWF_SECRET_SALT', 'xxxxxxxxxxxxxxxx'); # Changeme
define('GWF_CHMOD', 0777); # CHMOD mask for file creation. 0700 for mpm-itk env. 0777 in worst case
define('GWF_DB_HOST', 'localhost');
define('GWF_DB_USER', 'dog');
define('GWF_DB_PASSWORD', 'dog');
define('GWF_DB_DATABASE', 'dog');
define('GWF_DB_TYPE', 'mysqli'); # currently only mysql is supported
define('GWF_DB_CHARSET', 'utf8mb4'); # utf8 or utf8mb4
define('GWF_DB_ENGINE', 'myISAM'); # innoDB or myISAM
define('GWF_TABLE_PREFIX', ''); # Change at will, dual install possible.

#############################
### Session/Cookie Config ###
#############################
define('GWF_SESS_NAME', 'DOG'); # cookie name
define('GWF_SESS_SECURE', false); # cookie is ssl only
define('GWF_SESS_LIFETIME', 432000); # cookie lifetime
define('GWF_SESS_PER_USER', 3); # sessions max per user

###################
### IP Settings ###
###################
define('GWF_IP_QUICK', 'hash_32_1');  # Hashed IP Duplicates (see GWF_IP6.php)
define('GWF_IP_EXACT', 'bin_32_128'); # Complete IP storage (see GDO/IP6.php)

####################
### Email Config ###
####################
define('GWF_DEBUG_EMAIL', 0xFF); # 0=NONE, 1=DB ERRORS, 2=PHP_ERRORS, 4=404, 8=403
define('GWF_BOT_EMAIL', 'robot@giz.org');
define('GWF_ADMIN_EMAIL', 'gizmore@giz.org');
define('GWF_STAFF_EMAILS', ''); # separate cc plain emails by, (not really used yet)
define('GWF_SUPPORT_EMAIL', 'support@giz.org'); # all staff members should catch those
?>
