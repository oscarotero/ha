<?php
$target = empty($target) ? '' : 'data-target-selector="'.$target.'"';
$prevPage = $model->getPrevPage();
$nextPage = $model->getNextPage();

if (!$prevPage && !$nextPage) {
	return;
}
?>

<nav class="pagination">
	<ul>
		<?php if ($prevPage): ?>
		<li>
			<a href="<?= $this->query($prevPage, $form) ?>" <?= $target ?>>
				<?php $this->insert('partials/icons/arrow_left'); ?>
				<?php if (!$nextPage): ?>
					<span>Página anterior</span>
				<?php endif ?>
			</a>
		</li>
		<?php endif ?>

		<?php if ($nextPage): ?>
		<li>
			<a href="<?= $this->query($nextPage, $form) ?>" <?= $target ?>>
				<span>Página siguiente</span>
				<?php $this->insert('partials/icons/arrow_right'); ?>
			</a>
		</li>
		<?php endif ?>
	</ul>
</nav>