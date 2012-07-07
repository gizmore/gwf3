<?php
/**
 * @todo rename
 * @author spaceone
 */
final class GWF_HTTPStatus //extends GDO
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

/* TODO: remove; this is the wrong place for logging/saving != 2XX errors
	public function getTableName() { return GWF_TABLE_PREFIX.'httprequests'; }
	public function getClassName() { return __CLAS__; }
	public function getColumnDefines()
	{
		return array(
			'http_id' => array(),
			'http_uid' => array(),
			'http_code' => array(),
			'http_request_uri' => array(),
			'http_date' => array(),
		);
	}
*/

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

	private $messages;
	private $errors;

	/**
	 *
	 * @todo make it GWF_Error compatible
	 * @todo add setter
	 */
	public function __construct($status, $content, $messages=array(), $errors=array())
	{
		$this->status = $status;
		$this->content = $content;
		$this->messages = $messages;
		$this->errors = $errors;
	}

	public function getStatus() { return $this->status; }
	public function getContent() { return $this->content; }
	public function getErrors() { return $this->errors; }
	public function getMessages() { return $this->messages; }


	/**
	 * Set HTTP status code
	 * @param int $code
	 * @param string $status
	 */
	public static function statuscode($code, $status)
	{
		header(sprintf('%s %d %s', Common::getProtocol(), $code, $status));
	}

	/**
	 * HTTP Redirect
	 * @param int $code 3xx
	 * @param string $status
	 * @param string $url redirection target
	 */
	public static function redirect($code, $status, $url)
	{
		self::statuscode($code, $status);
		header('Location: ' . $url);
	}
}
?>
