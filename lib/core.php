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
	
	public function renderRss() {
	    global $siteWebRoot, $siteURL, $siteTitle, $baseDir, $dateMask, $overviewTitleTemplate, $overviewRowTemplate, $useNiceUrls, $latestUpdate;
	    
	    $item = 
    		"<item>
    			<guid isPermaLink=\"true\">%s</guid>
    			<pubDate>%s</pubDate>
    			<title>%s</title>
    			<link>%s</link>
    			<description>%s</description>
    			<content:encoded>
    				<![CDATA[%s]]>
    			</content:encoded>    			
    		</item>";
	    
    	ob_start();
    		
	    foreach ($this->gallerydata as $gallery) {
			$thumb = generateThumbnail($gallery->thumbnail, $gallery->path);
			$path  = $useNiceUrls 
			            ? sprintf('%sgallery/%s', $siteURL, $gallery->safename)
            			: sprintf('%s?galleryID=%s', $siteURL, $gallery->safename);
			
            // Skip non-public, empty and titleless galleries in the thumbnail view
            if (! is_null($gallery->hidden) || count($gallery->files) == 0 || is_null($gallery->title)) {
            	continue;
            }

            if (! is_null($thumb)) {
				$row = $overviewRowTemplate;
				$row = str_replace('GALLERYURL', $path, $row);
				$row = str_replace('IMGSRC', sprintf("%s%s", $siteURL, substr($thumb, 1)), $row);
				$row = str_replace('GALLERYTITLE', $compiledTitle, $row);
				$row = str_replace('ALTTXT', '', $row);
				
				$content  = "<h1>" . _e($gallery->title) . "</h1>";
                $content .= "<p>" . _e($row) . "</p>";
                
                if (! is_null($gallery->description)) {
                    if (is_array($gallery->description)) {
                        foreach ($gallery->description as $descrow) {
                            $content .= "<p>" . _e($descrow) . "</p>";
                        }
                    } else {
                        $content .= "<p>" . _e($gallery->description) . "</p>";
                    }
                }
				
				printf($item, 
                        $path,
                        date('r', $gallery->mtime),
                        _e($gallery->title),
                        $path,
                        count($gallery->files) . " images",
                        $content
                    );
			
				//print($row);
			} else {
			    //printf("<!-- %s: %s (%s) -->", "Could not get thumbnail for gallery", $gallery->title, $gallery->path);
			}
		}
		
		$this->output = ob_get_clean();
	}
	
	public function renderOverview() {
		global $siteWebRoot, $siteTitle, $baseDir, $dateMask, $overviewTitleTemplate, $overviewRowTemplate, $useNiceUrls, $latestUpdate;
		
		$latestUpdate = $this->latestUpdate;
		
		ob_start();

		foreach ($this->gallerydata as $gallery) {
			$thumb = generateThumbnail($gallery->thumbnail, $gallery->path);
			$path  = $useNiceUrls 
			            ? sprintf('%s/gallery/%s', $siteWebRoot, $gallery->safename)
            			: sprintf('%s/?galleryID=%s', $siteWebRoot, $gallery->safename);
			
            // Skip non-public, empty and titleless galleries in the thumbnail view
            if (! is_null($gallery->hidden) || count($gallery->files) == 0 || is_null($gallery->title)) {
            	continue;
            }

            if (! is_null($thumb)) {
                $compiledTitle = $overviewTitleTemplate;
                $compiledTitle = str_replace('GALLERYTITLE', $gallery->title, $compiledTitle);
                $compiledTitle = str_replace('GALLERYUPDATED', date($dateMask, $gallery->mtime), $compiledTitle);
                $compiledTitle = str_replace('GALLERYNUMIMAGES', count($gallery->files), $compiledTitle);
                
				$row = $overviewRowTemplate;
				$row = str_replace('GALLERYURL', $path, $row);
				$row = str_replace('IMGSRC', sprintf("%s%s", $siteWebRoot, $thumb), $row);
				$row = str_replace('GALLERYTITLE', $compiledTitle, $row);
				$row = str_replace('ALTTXT', '', $row);
				
				print($row);
			} else {
			    printf("<!-- %s: %s (%s) -->", "Could not get thumbnail for gallery", $gallery->title, $gallery->path);
			}
		}
		
		$this->output = ob_get_clean();
	}
	
	public function renderGallery() {
		global $siteWebRoot, $useNiceUrls, $galleryTitle, $galleryDescription, $galleryKeywords, $galleryDate, $galleryRowTemplate, $galleryIndexLink, $olderGalleryLink, $olderGalleryTitle, $newerGalleryLink, $newerGalleryTitle;
		
		$newerGalleryLink  = null;
		$olderGalleryLink  = null;
		$newerGalleryTitle = null;
		$olderGalleryTitle = null;
		$galleryIndexLink  = $useNiceUrls
		                        ? sprintf("%s/index/", $siteWebRoot)
        		                : sprintf("%s?index=", $siteWebRoot);
		$galleryId         = getRequestVar('galleryID');
		
		if (is_null($galleryId) || empty($galleryId)) {
		    forwardTo($galleryIndexLink);
		}
		
		ob_start();
		
		$keys = array_keys($this->gallerydata);
		
		for ($i = 0; $i < count($keys); $i++) {
		    $gallery = $this->gallerydata[$keys[$i]];
		    
			if ($gallery->safename == $galleryId) {
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
				
				for ($j = $i - 1; $j >= 0; $j--) {
				    $newerGallery = $this->gallerydata[$keys[$j]];
				    
				    if (is_null($newerGallery->hidden)) {
				        $newerGalleryTitle = $newerGallery->title;
    				    $newerGalleryLink  = $useNiceUrls 
    			            ? sprintf('%s/gallery/%s', $siteWebRoot, $newerGallery->safename)
                			: sprintf('%s/?galleryID=%s', $siteWebRoot, $newerGallery->safename);
                			
                		break;
            		}
				}
				
				for ($j = $i + 1; $j < count($keys) - 1; $j++) {
				    $olderGallery     = $this->gallerydata[$keys[$j]];
				    
				    if (is_null($olderGallery->hidden)) {
				        $olderGalleryTitle = $olderGallery->title;
    				    $olderGalleryLink  = $useNiceUrls 
    			            ? sprintf('%s/gallery/%s', $siteWebRoot, $olderGallery->safename)
                			: sprintf('%s/?galleryID=%s', $siteWebRoot, $olderGallery->safename);
                			
                		break;
            		}
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
			
			if (! is_null($gal)) {
    			$key = $gal->mtime;
    			
    			while (array_key_exists("k" . $key, $this->gallerydata)) {
    				$key++;
    			}
    			
    			$this->gallerydata["k" . $key] = $gal;
			}
		}
	}
	
	private function sortGalleryData() {
		krsort($this->gallerydata);
	}
	
	private function getGallery($path) {
		$path = str_replace("\\", "/", $path); // windows hack
		
		return Gallery::createGallery($path);
	}
}
?>