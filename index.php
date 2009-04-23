<?php  
require_once 'config.php';

header("Content-type: text/html; charset=utf-8");

// Shorten session length to 5 minutes, and set http only true
session_set_cookie_params(300, $siteWebRoot, $_SERVER['HTTP_HOST'], false, true);
session_name('SimpleGallerySession');
session_start();

if (isIndexRequest()) {
	SimpleGallery::getInstance()->renderOverview();
	require_once 'templates/index.template.php';
} else if (isGalleryRequest()) {
	SimpleGallery::getInstance()->renderGallery();
	require_once 'templates/gallery.template.php';
} else {
    require_once 'templates/landing.template.php';
}
?>
