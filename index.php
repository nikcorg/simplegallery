<?php
require_once dirname(__FILE__) . '/config.php';

header("Content-Type: text/html; charset=utf-8", true);

// Shorten session length to 5 minutes, and set http only true
session_set_cookie_params(300, $siteWebRoot . '/', $_SERVER['HTTP_HOST'], false, true);
session_name('SimpleGallerySession');
session_start();

if (isRssRequest()) {
    if (! (feedCacheExists() && serveCachedFeed())) {
        ob_start();

        SimpleGallery::getInstance()->renderRss();
        require_once 'templates/rss.template.php';

        if (cacheFeedContents(ob_get_clean())) {
            serveCachedFeed();
        }
    }
}
else if (isIndexRequest()) {
    SimpleGallery::getInstance()->renderOverview();
    require_once 'templates/index.template.php';
} else if (isGalleryRequest()) {
    SimpleGallery::getInstance()->renderGallery();
    require_once 'templates/gallery.template.php';
} else {
    if (isset($skipLandingPage) && $skipLandingPage) {
        if ($useNiceUrls) {
            forwardTo($siteWebRoot . '/index/');
        } else {
            forwardTo($siteWebRoot . '/?index=');
        }
    }
    require_once 'templates/landing.template.php';
}
