<?php header("Content-type: application/rss+xml"); ?>
<?php print("<?"); ?>xml version="1.0" encoding="UTF-8"<?php print("?>\n"); ?>
<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:atom="http://www.w3.org/2005/Atom"
>
<channel>
    <atom:link href="<?php echo $siteURL ?><?php echo $useNiceUrls ? "rss/" : "?rss=1" ?>" rel="self" type="application/rss+xml" />
    <title><?php echo $siteTitle ?></title>
    <link><?php echo $siteURL ?></link>
    <description><?php echo $siteDescription ?></description>
    
    <?php echo SimpleGallery::getInstance()->getOutput() ?>
</channel>
</rss>