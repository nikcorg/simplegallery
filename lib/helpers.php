<?php
function feedCacheExists() {
	$cacheFile = CACHEDIR . '/rss.xml';

	return (file_exists($cacheFile)) && (filemtime($cacheFile) + CACHETTL > time());
}

function serveCachedFeed() {
	$cacheFile = CACHEDIR . '/rss.xml';
	$cacheAge  = filemtime($cacheFile);

	header('Content-Type: application/rss+xml; charset=utf-8', true);
	header('Last-Modified: ' . date('r', $cacheAge));
	header('ETag: ' . md5($cacheAge));
	header('Expires: ' . date('r', $cacheAge + CACHETTL));
	header('Cache-Control: no-cache, must-revalidate, proxy-revalidate, public');

	readfile($cacheFile);
	exit();
}

function cacheFeedContents($contents) {
	$cacheFile = CACHEDIR . '/rss.xml';

	return file_put_contents($cacheFile, $contents);
}

function isUTF8($str) {
	return (utf8_encode(utf8_decode($str)) == $str);
}

function isRssRequest() {
    return ! is_null(getRequestVar('rss'));
}

function isGalleryRequest() {
	return ! is_null(getRequestVar('galleryID'));
}

function isIndexRequest() {
    return ! is_null(getRequestVar('index'));
}

function forwardTo($url) {
    header("Location: " . $url, true, 301);
    exit();
}

function getRequestVar($var) {
	if (isset($_GET[$var])) {
		return $_GET[$var];
	} else if (isset($_POST[$var])) {
		return $_POST[$var];
	}

	return null;
}

function endsWith($needle, $haystack) {
	$extract = substr($haystack, strlen($haystack) - strlen($needle));

	return ($needle == $extract);
}

function getUrlSafeString($str) {
	$pat = array('/[\s]/', '/[^A-Za-z0-9-]/');
	$rep = array('-', '');

	return preg_replace($pat, $rep, strtolower(trim($str)));
}

function _e($str) {
    if (! isUTF8($str)) {
        return utf8_encode($str);
    }

    return $str;
}

function getFolderNameFromPath($path) {
	if (endsWith("/", $path)) {
		$path = substr($path, 0, -1);
	}

	return substr($path, strrpos($path, "/") + 1);
}

function getFileExtension($filename) {
    return substr($filename, strrpos($filename, '.') + 1);
}

function generateThumbnail($img, $path, $force = true) {
	global $baseDir, $genImgDir, $thumbSize;

	$imgfile   = $path . '/' . $img;
	$thumbfile = $baseDir . $genImgDir . 'th_' . md5($path . $img) . '.' . getFileExtension($img);

	if (($force || ! file_exists($thumbfile)) && file_exists($imgfile) && is_readable($imgfile) && is_writable($baseDir . $genImgDir)) {
	    switch (getFileExtension($img)) {
	        case "jpg":
	        case "jpeg":
	            $image = @imagecreatefromjpeg($imgfile);
	        break;

	        case "gif":
	            $image = @imagecreatefromgif($imgfile);
	        break;

	        case "png":
	            $image = @imagecreatefrompng($imgfile);
	        break;

	        default:
	            printf("<!-- %s: %s -->\n", "File format could not be recognized (tried: jpg, jpeg, gif or png)", $img);
	            return null;
	        break;
	    }


		if ($image) {
            list($width, $height) = getimagesize($imgfile);

            $scale     = ($thumbSize + 1) / min($width, $height);
            $newWidth  = $width  * $scale * 1.0;
            $newHeight = $height * $scale * 1.0;
            $thumb     = imagecreatetruecolor($thumbSize, $thumbSize);

            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            if (! imagejpeg($thumb, $thumbfile)) {
            	printf("<!-- %s: %s -->\n", "Error creating thumbnail: error writing thumbnail to disk", $thumbfile);
            	return null;
            }

            chmod($thumbfile, 0644);
            imagedestroy($image);
            imagedestroy($thumb);
        } else {
        	printf("<!-- %s: %s -->\n", "Error creating thumbnail: could not open source image", $imgfile);
        	return null;
        }
	} else if (! file_exists($thumbfile)) {
		return null;
	}

	return $genImgDir . basename($thumbfile);
}
?>