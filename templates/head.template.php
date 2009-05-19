<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">    
    <?php if (is_array($siteTitle)): ?>
	    <?php foreach ($siteTitle as $lang => $title): ?>
	    	<meta name="DC.Title" lang="<?php echo $lang ?>" content="<?php echo $title ?>">
	    <?php endforeach; reset($siteTitle); ?>
    <?php else: ?>
    	<meta name="DC.Title" lang="<?php echo $siteDefaultLang ?>" content="<?php echo $siteTitle ?>">
    <?php endif; ?>
    
    <meta name="DC.Creator" lang="<?php echo $siteDefaultLang ?>" content="<?php echo $siteOwner ?>">
    
    <?php if (isset($galleryDescription) && ! empty($galleryDescription)): ?>
        <meta name="Description" content="<?php echo $galleryDescription ?>">
    <?php else: ?>
        <meta name="Description" content="<?php echo $siteDescription ?>">
    <?php endif; ?>
    
    <?php if (isset($galleryKeywords) && ! empty($galleryKeywords)): ?>
        <meta name="Keywords" content="<?php echo $galleryKeywords ?>">
    <?php else: ?>
        <meta name="Keywords" content="<?php echo $siteKeywords ?>">
    <?php endif; ?>
    
    <title><?php if (isset($galleryTitle) && ! empty($galleryTitle)): ?><?php echo $galleryTitle ?> | <?php endif; ?><?php echo is_array($siteTitle) ? $siteTitle[$siteDefaultLang] : $siteTitle ?></title>
    
    <link rel="alternate" title="<?php echo $siteTitle ?>" type="application/rss+xml" href="<?php echo $siteURL ?><?php echo $useNiceUrls ? "rss/" : "?rss=1" ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteWebRoot ?>/assets/css/style.css">
    
    <script type="text/javascript">
	var siteWebRoot = '<?php echo $siteWebRoot ?>';
    </script>
    
    <script type="text/javascript" src="<?php echo $siteWebRoot ?>/assets/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteWebRoot ?>/assets/js/jquery.lazyload.mini.js"></script>
    <script type="text/javascript" src="<?php echo $siteWebRoot ?>/assets/js/global.js"></script>
</head>
<body>
