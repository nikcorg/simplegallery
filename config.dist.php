<?php  
	// VCard details
	$siteOwner           = "John Doe";
	$siteOwnerTitle      = "Photographer";
	$siteOwnerTel        = "555-1234";
	$siteOwnerEmail      = "me@mydomain.com";
	
	// Site information
	$siteDefaultLang     = "en";
	$siteURL             = "http://www.mydomain.com/";
	$siteDescription     = "Lorem ipsum dolor sit amet";
	$siteKeywords        = "Lorem, Ipsum, Dolor, Sit, Amet";
	$siteTitle           = "My Awesome Photo Gallery";
	// For titling in several languages (for indexing purposes only), use the below scheme
	/*
	$siteTitle           = array(
				'en'=>"Lorem Ipsum in English", 
				'fi'=>"Lorem ipsum suomeksi", 
				'sv'=>"Lorem ipsum på svenska"
				);
	*/
	
	// Output templates, leave untouched if unsure about what you're doing
	// the title-attribute in the thumbnail view
	$overviewTitleTemplate = "GALLERYTITLE, GALLERYNUMIMAGES images, updated on GALLERYUPDATED"; 	
	// one gallery in the thumbnail view
	$overviewRowTemplate   = "<a href=\"GALLERYURL\" title=\"GALLERYTITLE\"><img src=\"IMGSRC\" alt=\"ALTTXT\"></a>\n"; //
	// one image in the gallery view
	$galleryRowTemplate    = "<div class=\"galleryimage\"><a href=\"#IMGID\"><img id=\"IMGID\" src=\"IMGSRC\" alt=\"ALTTXT\"></a></div>\n";

	// Thumbnail side length 
	$thumbSize = 100;

	// Other settings
	$useNiceUrls     = true;
	$skipLandingPage = true;
	$dateMask        = 'd.m.Y'; // see http://php.net/date
	$backToIndexStr  = "Return to gallery index";
	$siteWebRoot     = ''; // omit the trailing slash. for root folder, leave empty.
	$baseDir         = str_replace("\\", "/", dirname(__FILE__));
	$galleriesDir    = "/assets/galleries/";
	$genImgDir       = "/assets/img/generated/";
	
	require_once 'lib/core.php';
	require_once 'lib/gallery.php';
	require_once 'lib/helpers.php';
?>
