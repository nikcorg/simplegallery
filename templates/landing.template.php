<?php require_once 'head.template.php'; ?>

<div id="landing">
    <h1><?php echo _e(is_array($siteTitle) ? current($siteTitle) : $siteTitle) ?></h1>
    <p><?php echo _e($siteDescription) ?></p>

    <p><a href="<?php echo $useNiceUrls ? './index/' : './?index=' ?>">Enter</a></p>
</div>

<?php require_once 'tail.template.php'; ?>
