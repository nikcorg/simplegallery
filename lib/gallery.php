<?php  
class Gallery {
	public  static $latestUpdate = 0;
	private static $galleries    = array();
	
	private static function isUnique($safename) {
		foreach ($galleries as $gallery) {
			if ($gallery->safename == $safename) {
				return false;
			}
		}
		
		return true;
	}
	
	private static function isFolderReadable($path) {
		return is_readable($path);
	}
	
	private static function isInfoFileReadable($path) {
		$infofile = $path . '/info.txt';
		
		return (file_exists($infofile) && is_readable($infofile));
	}
	
	var $mtime;
	var $title;
	var $safename;
	var $date;
	var $description;
	var $keywords;
	var $path;
	var $foldername;
	var $files;
	var $thumbnail;
	
	public function __construct($path = null) {
		if (! is_null($path)) {
			$this->setPath($path);
		}
		
		self::$galleries[] &= $this;
	}
	
	public function setPath($path) {
		// Require readable dir and existing (and readable) info file
		if (self::isFolderReadable($path) && self::isInfoFileReadable($path)) {
			$this->path       = $path;
			$this->mtime      = filemtime($path);
			$this->foldername = getFolderNameFromPath($this->path);
			$this->safename   = getUrlSafeString(getFolderNameFromPath($this->path));
			
			if ($this->mtime > self::$latestUpdate) {
				self::$latestUpdate = $this->mtime;
			}
			
			$this->parseInfoFile();
			$this->scanFiles();
		} 
	}
	
	private function parseInfoFile() {
		$infofile = $this->path . '/info.txt';
		$contents = file($infofile);
		
		foreach ($contents as $row) {
			list($ident, $data) = preg_split("/[\s]/", trim($row), 2);
			
			$data = trim($data);
			
			switch (strtolower($ident)) {
				case 'title':
					$this->title = htmlspecialchars(_e($data));
				break;
				
				case 'desc':
					$this->description = _e($data);
				break;
				
				case 'keyw':
					$this->keywords = _e($data);
				break;
				
				case 'date':
					$this->date = _e($data);
				break;
				
				case 'thumb':
				    $this->thumbnail = $data;
				break;
			}
		}
	}
	
	private function scanFiles() {
		$files = glob($this->path . '/*');
		$ret   = array();
		
		foreach ($files as $file) {
			if (basename($file) == 'info.txt') continue;
			
			if (is_null($this->thumbnail)) {
				$this->thumbnail = basename($file);
			} else if (! file_exists($this->path . '/' . $this->thumbnail)) {
			    $this->thumbnail = basename($file);
			}
			
			$this->files[] = basename($file);
		}
		
		return $ret;
	}
}
?>