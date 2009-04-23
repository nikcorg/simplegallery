<?php require_once 'head.template.php'; ?>

<div id="landing">
	<h1><?php echo _e(is_array($siteTitle) ? current($siteTitle) : $siteTitle) ?></h1>
	<p><?php echo _e($siteDescription) ?></p>
	
	<a href="<?php echo $useNiceUrls ? './index/' : './?index=' ?>"><img src="assets/img/vettis.jpg" width="499" height="650" alt="<?php echo $siteOwner ?>"></a>
</div>

<?php require_once 'tail.template.php'; ?>
