<?php
/**
 * ZipArchiveImproved extends ZipArchive to add some information about the zip file and some functionality.
 * 
 * 27.Jun.2009 - Renamed class to ZipArchivePlus. (Gizmore)
 * 12.Nov.2009 - Renamed class to GWF_ZipArchive. (Gizmore)
 * 
 * @author Farzad Ghanei
 * @uses ZipArchive
 * @version 1.0.0 2009-01-18
 */
final class GWF_ZipArchive extends ZipArchive
{
	protected $_archiveFileName = null;
	protected $_totalFilesCounter = 0;
	protected $_newAddedFilesCounter = 0;
	protected $_newAddedFilesSize = 1000;
   
	/**
	 * returns the name of the archive file.
	 *
	 * @return string
	 */
	public function getArchiveFileName()
	{
		return $this->_archiveFileName;
	}
	
	public function getTotalFilesCounter()
	{
		return $this->_totalFilesCounter;
	}

	/**
	 * returns the number of files that are going to be added to ZIP
	 * without reopenning the stream to file.
	 *
	 * @return int
	 */
	public function getNewAddedFilesSize()
	{
		return $this->_newAddedFilesSize;
	}

	/**
	 * sets the number of files that are going to be added to ZIP
	 * without reopenning the stream to file. if no size is specified, default is 100.
	 *
	 * @param int
	 * @return ZipArchiveImproved self reference
	 */
	public function setNewlAddedFilesSize($size=1000)
	{
		if ( empty($size) || !is_int($size) || $size < 1) {
			$size = 1000;
		}
		$this->_newAddedFilesSize = $size;
		return $this;
	}

	/**
	 * opens a stream to a ZIP archive file. calls the ZipArchive::open() internally.
	 * overwrites ZipArchive::open() to add the archiveFileName functionality.
	 *
	 * @param string $fileName
	 * @param int $flags
	 * return mixed
	 */
	public function open($fileName, $flags=0)
	{
		$this->_archiveFileName = $fileName;
		$this->_newAddedFilesCounter = 0;
		return parent::open($fileName,$flags);
	}

	/**
	 * closes the stream to ZIP archive file. calls the ZipArchive::close() internally.
	 * overwrites ZipArchive::close() to add the archiveFileName functionality.
	 *
	 * @return bool
	 */
	public function close()
	{
		$this->_archiveFileName = null;
		$this->_newAddedFilesCounter = 0;
		return parent::close();
	}

	/**
	 * closes the connection to ZIP file and openes the connection again.
	 *
	 * @return bool
	 */
	public function reopen()
	{
		$archiveFileName = $this->_archiveFileName;
		if ( !$this->close() ) {
			return false;
		}
		return $this->open($archiveFileName, self::CREATE);
	}

	/**
	 * adds a file to a ZIP archive from the given path. calls the ZipArchive::addFile() internally.
	 * overwrites ZipArchive::addFile() to handle maximum file connections in operating systems.
	 *
	 * @param string $fileName the path to file to be added to archive
	 * @param string [optional] $localname the name of the file in the ZIP archive
	 * @return bool
	 */
	public function addFile($filename=NULL, $localname=NULL, $start=0, $end=0)
	{
		if ($this->_newAddedFilesCounter >= $this->_newAddedFilesSize) {
			if (true !== ($ret = $this->reopen())) {
				echo 'Can not re-open zip, when adding file: '.$filename.PHP_EOL;
				echo 'Total zipfile counter: '.$this->_totalFilesCounter.PHP_EOL;
				echo 'Errorcode: '.$ret.PHP_EOL;
				return false;
			}
		}
		
		if (!file_exists($filename)) {
			die('File not found:'.$filename);
		}
		
		if ( func_num_args() > 1 )
		{
			$localname = func_get_arg(1);
			$added = parent::addFile($filename, $localname);
			if ($added) {
				$this->_newAddedFilesCounter++;
				$this->_totalFilesCounter++;
			}
			return $added;
		}
		else
		{
			
			$added = parent::addFile($filename);
			if ($added) {
				$this->_newAddedFilesCounter++;
				$this->_totalFilesCounter++;
			}
			
			return $added;
		}
	}
}
