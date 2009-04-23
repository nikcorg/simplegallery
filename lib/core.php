<?php  
class SimpleGallery {
	private static $instance = null;
	
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new SimpleGallery();
		}
		
		return self::$instance;
	}
	
	private $gallerydata;
	private $latestUpdate;
	private $output;
	
	private function __construct() {
		$this->gallerydata = array();
		$this->output      = "";
		
		if (! is_null(getRequestVar('purge')) || ! isset($_SESSION['SimpleGalleryData'])) {
			$this->buildGalleryData();
			$this->sortGalleryData();
			$this->latestUpdate = Gallery::$latestUpdate;
			
			$_SESSION['SimpleGalleryData'] = serialize($this->gallerydata);
			$_SESSION['LatestUpdate']      = serialize($this->latestUpdate);
		} else {
			$this->gallerydata  = unserialize($_SESSION['SimpleGalleryData']);
			$this->latestUpdate = unserialize($_SESSION['LatestUpdate']);
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function renderOverview() {
		global $siteWebRoot, $siteTitle, $baseDir, $overviewRowTemplate, $useNiceUrls, $latestUpdate;
		
		$latestUpdate = $this->latestUpdate;
		
		ob_start();

		foreach ($this->gallerydata as $gallery) {
			$thumb = generateThumbnail($gallery->thumbnail, $gallery->path);
			$path  = $useNiceUrls 
			            ? sprintf('%s/gallery/%s', $siteWebRoot, $gallery->safename)
            			: sprintf('%s/?galleryID=%s', $siteWebRoot, $gallery->safename);
			
            if (! is_null($thumb)) {
				$row = $overviewRowTemplate;
				$row = str_replace('GALLERYURL', $path, $row);
				$row = str_replace('IMGSRC', sprintf("%s%s", $siteWebRoot, $thumb), $row);
				$row = str_replace('GALLERYTITLE', $gallery->title, $row);
				$row = str_replace('ALTTXT', '', $row);
				
				print($row);
			}
		}
		
		$this->output = ob_get_clean();
	}
	
	public function renderGallery() {
		global $siteWebRoot, $useNiceUrls, $galleryTitle, $galleryDescription, $galleryKeywords, $galleryDate, $galleryRowTemplate, $galleryIndexLink;
		
		$gal              = getRequestVar('galleryID');
		$galleryIndexLink = $useNiceUrls
		                        ? sprintf("%s/index/", $siteWebRoot)
        		                : sprintf("%s?index=", $siteWebRoot);
		
		ob_start();
				
		foreach($this->gallerydata as $gallery) {
			if ($gallery->safename == $gal) {
				$galleryTitle       = $gallery->title;
				$galleryDescription = $gallery->description;
				$galleryKeywords    = $gallery->keywords;
				$galleryDate        = $gallery->date;
				$galleryPath        = sprintf('%s/assets/galleries/%s', $siteWebRoot, $gallery->foldername);
				
				foreach ($gallery->files as $image) {
					$row = $galleryRowTemplate;
					$row = str_replace('IMGSRC', sprintf("%s/%s", $galleryPath, $image), $row);
					$row = str_replace('ALTTXT', '', $row);
					
					print($row);
				}
				
				break;
			}
		}
		
		$this->output = ob_get_clean();
	}
	
	private function buildGalleryData() {
		global $baseDir, $galleriesDir;
		
		$galleries = glob($baseDir . $galleriesDir . '*', GLOB_ONLYDIR);
		
		foreach ($galleries as $gallery) {
			$gal = $this->getGallery($gallery);			
			$key = $gal->mtime;
			
			while (array_key_exists($key, $this->gallerydata)) {
				$key++;
			}
			
			$this->gallerydata["k" . $key] = $gal;
		}
	}
	
	private function sortGalleryData() {
		krsort($this->gallerydata);
	}
	
	private function getGallery($path) {
		$path = str_replace("\\", "/", $path); // windows hack
		
		return new Gallery($path);
	}
}
?>