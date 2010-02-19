<?php require_once 'head.template.php'; ?>

<div id="masthead">
    <div id="hcard-<?php echo _e(str_replace(' ', '-', $siteOwner)) ?>" class="vcard">
        <h1><a href="<?php echo _e($siteURL) ?>" class="url fn"><?php echo _e($siteOwner) ?></a>, <?php echo _e($siteOwnerTitle) ?></h1>
        <p><a class="email" href="mailto:<?php echo str_replace('@', '&#0064;', _e($siteOwnerEmail)) ?>"><?php echo str_replace('@', '&#0064;', _e($siteOwnerEmail)) ?></a> <span class="tel"><?php echo _e($siteOwnerTel) ?></span></p>
    </div>
    
    <?php if (isset($latestUpdate) && $latestUpdate != 0): ?>
    <p>Latest update <?php echo _e(date("d.m.Y", $latestUpdate)) ?></p>
    <?php endif; ?>
</div>

<div id="overview" class="clearfix">
    <?php echo SimpleGallery::getInstance()->getOutput(); ?>
</div>

<?php require_once 'tail.template.php'; ?>
