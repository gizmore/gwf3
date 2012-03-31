<?php
/**
 * SVN Information Class, SVNInfo
 * Class to fetch various Information from a SVN Server.
 *
 * Simple Example:
 *
 * $svninfo = new SVNnfo();
 *
 * $svninfo->setRepository("http://svn.example.com/branches/myproject", "foouser", "barpassword");
 *
 * $currentRevision = $svninfo->getCurrentRevision();
 *
 * // Get the SVN-Log from Revision 1900 to the HEAD-Revision
 * $svnlog = $svninfo->getLog(1900, $currentRevision);
 *
 * // This is also possible:
 * $svninfo->setRepository("http://svn.example.com/branches/myproject/file.php", "foouser", "barpassword");
 * $svnlog = $svninfo->getLog(0, 100);
 *
 * @author Markus Schlegel <g42@gmx.net>
 * @author Florian Schmitz <floele@gmail.com>
 * @author livinskull <livinskull@gmail.com>
 * @license http://opensource.org/licenses/lgpl-license.php GNU Lesser General Public License
 * @version 0.7
 * @package SVNInfo
 */


/**
 * SVN Information Class, SVNInfo
 * Class to fetch various Information from a SVN Server.
 */
class GWF_SvnInfo {

	/**
	 * URL of the Repository
	 * @var string
	 */
	var $_reposURL;
	/**
	 * Username to authenticate to the Repository
	 * @var string
	 */
	var $_reposUsername;
	/**
	 * Password to authenticate to the Repository
	 * @var string
	 */
	var $_reposPassword;
	/**
	 * Header Request Method (PROPFIND, REPORT, OPTIONS, GET, ...)
	 * @var string
	 */
	var $_RequestType;
	/**
	 * Request Body
	 * @var string
	 */
	var $_RequestData;

	/**
	 * Set Repository Connect-Information
	 * @param string $url URL of the Repository
	 * @param string $username User to authenticate to the Repository (optional)
	 * @param string $password Password to authenticate to the Repository (optional)
	 */
	function setRepository($url, $username="", $password="") {
		$this->_reposURL 		= $url;
		$this->_reposUsername 	= $username;
		$this->_reposPassword 	= $password;
	}

	/**
	 * Set everything needed and send the Request to the SVN Server
	 * @return string Source-Code of the Result
	 */
	function _startRequest() {
		// Init connection
		$urlinfo = parse_url($this->_reposURL);
		$host = $urlinfo['host'];
		$port = 0;

		if (!empty($urlinfo['port']))
			$port = $urlinfo['port'];
		$schema = $urlinfo['scheme'];
		if ($schema == 'https' && empty($port))
			$port = 443;
		else if (empty($port))
			$port = 80;

		if ($schema == 'https')
			$host = "ssl://".$host;

		$fp = fsockopen($host, $port, $errorno, $errorstr, 10);

		if (!$fp) {
			return '';
		}

		stream_set_blocking($fp, 0);

		// Build request
		$request = array();
		$request[] = sprintf('%s %s HTTP/1.1', $this->_RequestType, $urlinfo['path']);
		$request[] = sprintf('Host: %s', $urlinfo['host']);
		$request[] = sprintf('Content-Length: %d', strlen($this->_RequestData));
		$request[] = 'Content-Type: application/x-www-form-urlencoded';
		$request[] = 'Connection: Close';

		// HTTP auth?
		if ($this->_reposUsername) {
		$request[] = sprintf('Authorization: Basic %s', base64_encode($this->_reposUsername . ':' . $this->_reposPassword));
		}

		$succ = fwrite($fp, implode("\r\n", $request) . "\r\n\r\n" . $this->_RequestData);

		if (!$succ)
			return '';


		// Read response
		$response = '';
		while (!feof($fp)) {
			$response .= fread($fp, 2048);
		}

		fclose($fp);

		return $response;
	}

	/**
	 * Retrieve the SVN-Log from Revision x to Revision y of the current 
Repository
	 * @param integer $startRevision First Log-Entry
	 * @param integer $endRevision Last Log-Entry
	 * @return array Array of Log-Arrays (Revision, Creator, Date, Comment)
	 */
	function getLog($startRevision, $endRevision) {
		// some sanity checks
		if ($startRevision > $endRevision) {
			$startRevision = $endRevision;
		}
		$latestRevision = $this->getCurrentRevision();
		if ($endRevision > $latestRevision) {
			$endRevision = $latestRevision;
		}

		// Form Request Body
		// Information from http://svn.collab.net/repos/svn/trunk/notes/webdav-protocol
		$request =  '';
		$request .= '<s:log-report xmlns:s="svn:">';
		$request .= '<s:start-revision>' . $startRevision . '</s:start-revision>';
		$request .= '<s:end-revision>' . $endRevision . '</s:end-revision>';
  		$request .= '<s:path></s:path>';
		$request .= '<s:discover-changed-paths>';
  		$request .= '</s:discover-changed-paths>';
		$request .= '</s:log-report>';

  		// Perform a REPORT-Request
  		$this->_RequestType = 'REPORT';
  		// Include the Request Body
  		$this->_RequestData = $request;

  		// Send Request and fetch the Result from the Server
  		$body = $this->_startRequest();

		//var_dump($body);

  		// Get CDATA from the Log-Elements
  		$versionNames 	= $this->getElementContents($body, 'D:version-name');
  		$creatorNames 	= $this->getElementContents($body, 'D:creator-displayname');
  		$dates	 		= $this->getElementContents($body, 'S:date');
  		$comments		= $this->getElementContents($body, 'D:comment');

		if (!is_array($versionNames)) {
			return false;
		}

  		// Combine the Data to one single Array
  		$nrentries = count($versionNames);
  		for ($i = 0; $i < $nrentries; $i++) {
  			$creatorName = "";
  			if (!empty($creatorNames[$i]))
  				$creatorName = $creatorNames[$i];
  			$comment = "";
  			if (!empty($comments[$i]))
  				$comment = $comments[$i];
  			$logentries[] = array(
  			'version-name' => $versionNames[$i],
  			'creator-displayname' => $creatorName,
  			'date' => $dates[$i],
  			'comment' => $comment
  			);
  		}

  		// Return the Log
  		return $logentries;
	}

	/**
	 * Retrieve the Revision-Number of a corresponding Date
	 * @return integer Revision-Number
	 */
	function getDatedRevision($date) {
		// Form Request Body
		// Information from http://svn.collab.net/repos/svn/trunk/notes/webdav-protocol
		$request =  '';
  		$request .= '<s:dated-rev-report xmlns:s="svn:" xmlns:d="DAV:">';
  		$request .= '<d:creationdate>' . gmdate("Y-m-d\\TH:i:s.000000\\Z", $date) . '</d:creationdate>';
  		$request .= '</s:dated-rev-report>';

  		// Perform a REPORT-Request
  		$this->_RequestType = 'REPORT';
  		// Include the Request Body
  		$this->_RequestData = $request;

  		// Send Request and fetch the Result from the Server
  		$body = $this->_startRequest();

		$datedRevision = $this->getElementContents($body, 'D:version-name');

		if (!is_array($datedRevision)) {
			return false;
		}

		if (!isset($datedRevision[0]))
		{
			return 0;
		}

		return (int)$datedRevision[0];
	}

	/**
	 * Retrieve the current Revision-Number of the SVN Url
	 * @return integer Revision-Number
	 */
	function getCurrentRevision() {
		return $this->getDatedRevision(time());
	}

	/**
	 * Get the contents of each XML element in $xml as array
	 * Usually we wouldn't want to use regular expressions for parsing, but this
	 * particular task can be done reliably with them since the escaping used in XML
	 * is compatible to regular expressions.
	 * @param string $xml
	 * @param string $element without < and > of course
	 * @return array like array('1123', '1234', '1235')
	 */
	function getElementContents($xml, $element) {
		$matches = array();
		preg_match_all('|<(' . preg_quote($element, '|') . ')>(.*)</\1>|Uuis', $xml, $matches);
		return $matches[2];
	}

}


