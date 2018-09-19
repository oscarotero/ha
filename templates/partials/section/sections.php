<?php

if (!empty($groupImages)) {
	$oldSections = $sections;
	$sections = [];

	foreach ($oldSections as $k => $section) {
		if ($section['type'] !== 'image') {
			$sections[] = $section;
			continue;
		}

		$key = count($sections) - 1;

		if (isset($sections[$key]) && $sections[$key]['type'] === 'gallery') {
			$sections[$key]['images'][] = $section;
			continue;
		}

		if (isset($oldSections[$k + 1]) && $oldSections[$k + 1]['type'] === 'image') {
			$sections[] = [
				'type' => 'gallery',
				'images' => [$section]
			];
			continue;
		}

		$sections[] = $section;
	}
}

$html = '';

foreach ($sections as $section) {
	$html .= $this->fetch('partials/section/'.$section['type'], [
		'section' => $section,
		'bigImages' => !empty($bigImages)
	]);
}

if (!empty($groupSections)) {
	$html = Typofixer\Typofixer::create($html);
	$body = $html->body();
	$section = null;
	$div = null;

	foreach (iterator_to_array($body->childNodes) as $child) {
		if (
			$child->nodeName === 'section' ||
			($child->nodeName === 'figure' && strpos($child->getAttribute('class'), 'section-code') !== false)
			) {
			$section = null;
			$div = null;
			continue;
		}

		if ($child->nodeName === 'figure') {
			if ($section) {
				$div = null;
				$section->appendChild($child);
			} elseif ($div) {
				$div->appendChild($child);
			}
			continue;
		}

		if ($child->nodeName === 'h2') {
    		$section = new DOMElement('section');
    		$div = null;
			$body->insertBefore($section, $child);
			$section->appendChild($child);
			continue;
		}

		if ($section) {
			if (!$div) {
				$div = new DOMElement('div');
				$section->appendChild($div);
			}

			$div->appendChild($child);
		} elseif ($div) {
			$div->appendChild($child);
		} else {
			$div = new DOMElement('div');
			$body->insertBefore($div, $child);
			$div->appendChild($child);
		}
	}
}

echo $html;
