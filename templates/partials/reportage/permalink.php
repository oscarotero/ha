<article class="reportage is-permalink ly-reportage tm-reportage-<?= $reportage->id ?>">
	<header class="reportage-header ly-reportage-header">
		<h1 class="reportage-title">
			<?= str_replace('(', '<br>(', $reportage->title) ?>
		</h1>
		
		<p class="reportage-subtitle">
			<?= $reportage->subtitle ?>
		</p>

		<nav class="reportage-nav taxonomy">
			<?php if ($reportage->author): ?>
			<p class="taxonomy-info">
				Escrito por: 
				<a href="<?= $this->url('author-permalink', ['slug' => $reportage->author->slug]) ?>">
					<?= $reportage->author->name ?>
				</a>
			</p>
			<?php endif ?>

			<?php
			$this->insert('partials/taxonomy-tags', [
				'tag' => $reportage->tag
			]);
			?>
		</nav>
	</header>


	<div class="reportage-body ly-reportage-body">
		<?php
		$this->insert('partials/section/sections', [
				'sections' => $reportage->body,
				'bigImages' => true,
				'groupImages' => true,
				'groupSections' => true
		]);
		?>
	</div>
</article>
