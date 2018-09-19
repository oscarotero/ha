<div class="widget" data-js="<?= $this->asset('js/widget_'.$name.'.js') ?>" data-css="<?= $this->asset('css/widgets', $name.'.css') ?>" id="widget-<?= $name ?>">
	<?php $this->insert('widgets/'.$name) ?>
</div>