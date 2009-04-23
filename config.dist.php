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
	
	// Row templates, leave untouched if unsure about what you're doing
	$overviewRowTemplate = "<a href=\"GALLERYURL\" title=\"GALLERYTITLE\"><img src=\"IMGSRC\" alt=\"ALTTXT\"></a>\n";
	$galleryRowTemplate  = "<div class=\"galleryimage\"><img src=\"IMGSRC\" alt=\"ALTTXT\"></div>\n";

	// Thumbnail settings 
	$thumbSize = 100;

	// Other settings
	$useNiceUrls    = true;
	$backToIndexStr = "Return to gallery index";
	$siteWebRoot    = ''; // omit the trailing slash. for root folder, leave empty.
	$baseDir        = str_replace("\\", "/", dirname(__FILE__));
	$galleriesDir   = "/assets/galleries/";
	$genImgDir      = "/assets/img/generated/";
	
	require_once 'lib/core.php';
	require_once 'lib/gallery.php';
	require_once 'lib/helpers.php';
?>
