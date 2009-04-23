<?php require_once 'head.template.php'; ?>
    
<div id="gallery">
	<h1><?php echo $galleryTitle ?></h1>
	
	<?php if (isset($galleryDate) && ! empty($galleryDate)): ?>
	    <p class="date"><?php echo $galleryDate ?></p>
	<?php endif; ?>
	
	<?php if (isset($galleryDescription) && ! empty($galleryDescription)): ?>
		<p class="description"><?php echo $galleryDescription ?></p>
	<?php endif; ?>
	
	<div id="images">
		<?php echo SimpleGallery::getInstance()->getOutput(); ?>
	</div>
	
	<p><a href="<?php echo $galleryIndexLink ?>"><?php echo $backToIndexStr ?></a></p>
</div>



<?php require_once 'tail.template.php'; ?>