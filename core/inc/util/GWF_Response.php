<?php
/**
 * A HTTP Response
 * @author spaceone
 */
final class GWF_Response
{
##	INFORMATIONAL = 1xx;
	const _CONTINUE = 100;
	const SWITCHING_PROTOCOLS = 101;
	const PROCESSING = 102;
##	SUCCESS = 2xx;
	const OK = 200;
	const CREATED = 201;
	const ACCEPTED = 202;
	const NON_AUTHORITATIVE_INFORMATION = 203;
	const NO_CONTENT = 204;
	const RESET_CONTENT = 205;
	const PARTIAL_CONTENT = 206;
	const MULTI_STATUS = 207;
	const ALREADY_REPORTED = 208;
	const IM_USED = 226;
##	REDIRECTIONS = 3xx;
	const MULTIPLE_CHOICES = 300;
	const MOVED_PERMANENTLY = 301;
	const FOUND = 302;
	const SEE_OTHER = 303;
	const NOT_MODIFIED = 304;
	const USE_PROXY = 305;
	const SWITCH_PROXY = 306;
	const TEMPORARY_REDIRECT = 307;
	const PERMANENT_REDIRECT = 308;
##	CLIENT_ERRORS = 4xx;
	const BAD_REQUEST = 400;
	const UNAUTHORIZED = 401;
	const PAYMENT_REQUIRED = 402;
	const FORBIDDEN = 403;
	const NOT_FOUND = 404;
	const METHOD_NOT_ALLOWED = 405;
	const NOT_ACCEPTABLE = 406;
	const PROXY_AUTHENTICATION_REQUIRED = 407;
	const REQUEST_TIMEOUT = 408;
	const CONFLICT = 409;
	const GONE = 410;
	const LENGTH_REQUIRED = 411;
	const PRECONDITION_FAILED = 412;
	const REQUEST_ENTITY_TOO_LARGE = 413;
	const REQUEST_URI_TOO_LONG = 414;
	const UNSUPPORTED_MEDIA_TYPE = 415;
	const REQUEST_RANGE_NOT_SATISFIABLE = 416;
	const EXPECTATION_FAILED = 417;
	const I_AM_A_TEAPOT = 418;
	const ENHANCE_YOUR_CALM = 420;
	const UNPROCESSABLE_ENTITY = 422;
	const LOCKED = 423;
	const FAILED_DEPENDENCY = 424;
	const METHOD_FAILURE = 424;
	const UNORDERED_COLLECTION = 425;
	const UPGRADE_REQUIRED = 426;
	const PRECONDITION_REQUIRED = 428;
	const TOO_MANY_REQUESTS = 429;
	const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
	const NO_RESPONSE = 444;
	const RETRY_WITH = 449; # Microsoft
	const BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS = 450; # Microsoft
	const UNAVAILABLE_FOR_LEGAL_REASONS = 451;
	const CLIENT_CLOSED_REQUEST = 499;
##	SERVER_ERRORS = 5xx;
	const INTERNAL_SERVER_ERROR = 500;
	const NOT_IMPLEMENTED = 501;
	const BAD_GATEWAY = 502;
	const SERVICE_UNAVAILABLE = 503;
	const GATEWAY_TIMEOUT = 504;
	const HTTP_VERSION_NOT_SUPPORTED = 505;
	const VARIANT_ALSO_NEGOTIATES = 506;
	const INSUFFICIENT_STORAGE = 507;
	const LOOP_DETECTED = 508;
	const BANDWIDTH_LIMIT_EXCEEDET = 509;
	const NOT_EXTENDED = 510;
	const NETWORK_AUTHENTICATION_REQUIRED = 511;
	const NETWORK_READ_TIMEOUT_ERROR = 598;
	const NETWORK_CONNECT_TIMEOUT_ERROR = 599;

	/**
	 * The HTTP Response code
	 * @var int $status
	 */
	private $status;

	/**
	 * The Response content
	 * @var string $content
	 */
	private $content;

	/**
	 * Error messages
	 * @var GWF_Error $error
	 */
	public $error;

	/**
	 * The redirect location
	 * @var string $location
	 */
	private $location;

	/**
	 * additional HTTP response header
	 * @var array $header
	 */
	private $header;

	/**
	 * HTTP method
	 * @var string $METHOD
	 */
	private $METHOD;

	/**
	 * HTTP GET request data
	 * @var array $GET
	 */
	private $GET;

	/**
	 * HTTP POST request data
	 * @var array $POST
	 */
	private $POST;

	/**
	 * HTTP request header
	 * @var array $HEADER
	 */
	private $HEADER;

	/**
	 * HTTP request body
	 * @var string $BODY
	 */
	private $BODY;

	/**
	 * HTTP request header cookies
	 * @var array $COOKIE
	 */
	private $COOKIE;

	/**
	 * server and client information provided by PHP
	 * @var array $SERVER
	 */
	private $SERVER;

	/**
	 * The user, authenticated by HTTP or cookie
	 * @var GWF_User $user
	 */
	private $user;

	public static $methods_allowed_to_cache = array('GET' => true, 'HEAD' => true);

	/**
	 *
	 * @todo make it GWF_Error compatible
	 * @todo header should not be a array, because it should be case insensitive
	 * @todo format | remember what was meant?
	 * @todo add a config param?
	 * @todo hook mechanisms
	 * @param $method HTTP request method ($_SERVER['REQUEST_METHOD'])
	 * @param $get HTTP request get data ($_GET)
	 * @param $post HTTP request post dara ($_POST)
	 * @param $body HTTP request body (file_get_contents('php://input'))
	 * @param $header HTTP request headers (GWF_HTTP::getHeaders())
	 * @param $cookie HTTP request cookies ($_COOKIE)
	 * @param $server client and server information ($_SERVER)
	 */
	public function __construct($method='GET', &$get, &$post, &$header, &$cookie, &$server, $body='')
	{
		# request
		$this->METHOD = $method;
		$this->HEADER = $header;
		$this->GET = $get;
		$this->POST = $post;
		$this->BODY = $body;
		$this->COOKIE = $cookie;
		$this->SERVER = $server;

		# response
		$this->status = self::OK;
		$this->content = '';
		$this->error = new GWF_Error();
		$this->header = array();
	}

	# TODO: split into void methods
	public function init()
	{
		list($modulename, $methodname) = array($this->GET['mo'], $this->GET['me']);

		# Authenticate
		if (false !== false) {
			# TODO: implement HTTP Authentification mechanisms
		}
		else {
			$this->user = GWF_Session::getUser();
		}

		# Load the module
		if (false === ($module = GWF_Module::loadModuleDB($modulename, $this)))
		{
			$this->status = self::NOT_FOUND;
			# TODO: GWF_Error module not found
			return false;
		}

		# Module is disabled?
		if (false === $module->isEnabled())
		{
			$this->status = self::NOT_FOUND; #TODO: which response code?
			# TODO: GWF_Error module disabled
			return false;
		}

		# initialize the module # FIXME: this can be happened in GWF_Module
		$module->onInclude();
		$module->onLoadLanguage(); # TODO: language header

//		# execute method
//		$content = $module->execute($this->METHOD, $methodname);

		# Load method
		if (false === ($method = $module->getMethod($methodname)))
		{
			$this->status = self::NOT_FOUND;
			# TODO: GWF_Error 'ERR_METHOD_MISSING' htmlspecialchars($methodname), $module->getName()
			return false;
		}

		# check permissions
		if (false === $method->hasPermission())
		{
			$this->status = self::UNAUTHORIZED; # FORBIDDEN ?
			# 'ERR_NO_PERMISSION'
			return false;
		}

		# Caching
		if (true === $this->get(self::$methods_allowed_to_cache, $this->METHOD))
		{
			# Conditional GET
			if (
				(false !== ($ifmodified = $this->HEADER->getHeader('If-Modified-Since'))) &&
				(false !== ($modified = $method->getModifiedTime())) &&
				($modified < $ifmodified)
			) {
				$this->status = self::NOT_MODIFIED;
				$this->content = '';
				return false;
			}

			# ETAG
			if (
				(false !== ($hetag = $this->HEADER->getHeader('E-Tag'))) &&
				(false !== ($etag = $method->getETag())) &&
				($etag === $hetag)
			) {
				# TODO: which status?
				$this->status = self::NOT_MODIFIED;
				$this->content = '';
				return false;
			}
		}

		$format = $this->getFormat(); #TODO

		try
		{
			# backwards compatibility
			$back = $method->execute($this->METHOD, $format, $tthis);
		}
		catch (GWF_Exception $e)
		{
			# TODO
		}
		catch (Exception $e)
		{
			$this->status = self::INTERNAL_SERVER_ERROR;
			# TODO: GWF_Error, GWF_Debug (if config)
			return false;
		}

		return true;
	}

	public function getLanguage($default)
	{
		# FIXME: use GWF_Language for this
		# FIXME: allow whole languages (de-DE) and check if language is existing, else use second.
		# NOTE: also decide if we support a fallback/GWF_DEFAULT_LANGUAGE if the client doesn't accept available languages
		$lang = substr($this->HEADER->getHeader('Accept-Language'), 0, 2);

		# TODO: by account setting, URL, etc...
	}

	public function getFormat($default)
	{
		# TODO: decide if GET[format] overwrites it
		if (false !== ($accept = $this->HEADER->getHeader('Accept')))
		{
			# TODO: parse
			$json = strpos($accept, 'application/json');
			$html = strpos($accept, 'text/html');
			$xml = strpos($accept, 'application/xml');
			$plain = strpos($accept, 'text/plain');
			# $rss, $atom
		}
		return $default;
		# return value could be a array containing (shorten?) mime types
	}

	public function &get(&$array, $key, $default=false)
	{
		if (isset($array[$key]))
		{
			return $array[$key];
		}
		return $default;
	}

	public function getStatus() { return $this->status; }
	public function getContent() { return $this->content; }
	public function getError() { return $this->errors; }
	public function getRedirect() { return $this->location; }

	public function setStatus($status) { $this->status = $status; }
	public function setContent($content) {$this->content = $content; }
	public function setRedirect($location) { $this->location = $location; }
	public function setHeader($header) { $this->header = $header; }

	public function addContent($content) {$this->content .= $content; }
	public function addHeader($header)
	{
		foreach ((array) $header as $head)
		{
			$this->header[] = $head;
		}
	}

	/**
	 * set HTTP Response Header and return the content
	 * 
	 */
	public function response()
	{
		$status = $this->getStatus();
		if ($status >= 300 && $status < 400)
		{
			# Redirection
			GWF_HTTPHeader::redirect($status, $this->getRedirect());
		}
		else
		{
			GWF_HTTPHeader::statuscode($status);
			if ($status >= 200 && $status < 300)
			{
				# Success
				if (true === $this->get(self::$methods_allowed_to_cache, $this->METHOD))
				{
					# TODO: set Modified Time and E-Tag
				}

			}
		}

		GWF_HTTPHeader::setHeaders($this->headers);

		# TODO: add GWF_Error

		return $this->getContent();
	}
	
	public function __toString()
	{
		return sprintf("%s %d %s\r\n%s\r\n\r\n%s", $this->SERVER['SERVER_PROTOCOL'], $this->status, $this->status, implode("\r\n", $this->header), $this->content);
	}
}
?>
