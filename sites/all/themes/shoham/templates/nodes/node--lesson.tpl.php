
    <?php if ($teaser): ?>
    <div id="one">
        <?php print render($content['field_main_image_lesson']); ?>
    	<h3><a href="/node/<?php print $nid; ?>"><?php print $title; ?></a></h3>
    </div>
	<?php else: ?>
		<?php print render($content); ?>
		<div class="button-q"><a href="/comment/reply/<?php print $nid; ?>" class="add-q"> יש לי שאלה</a></div>
	<?php endif; ?>
