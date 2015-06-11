
    <?php if ($teaser): ?>
    <div id="one">
        <?php print render($content['field_main_image_course']); ?>
    	<h3><a href="/node/<?php print $nid; ?>"><?php print $title; ?></a></h3>
    </div>
	<?php else: ?>
		<?php print render($content); ?>
	<?php endif; ?>
