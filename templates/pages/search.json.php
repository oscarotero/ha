<?php

$suggestions = [];

if ($artists->count()) {

	$suggestions[] = [
		'label' => 'Artistas',
		'type' => 'artist',
		'options' => array_values(array_map(function ($artist) {

			$detail = $artist->yearBorn ?: '?';

			if ($artist->yearDead) {
				$detail .= '–'.$artist->yearDead;
			}

			return [
				'label' => "{$artist->name}  {$artist->surname}",
				'detail' => $detail,
				'value' => $this->url('artist-permalink', ['slug' => $artist->slug])->getPath(),
				'img' => $this->img($artist->imageFile, 'resizeCrop,80,80')->getPath(),
			];
		}, $artists->toArray(false)))
	];
}

if ($artworks->count()) {
	$suggestions[] = [
		'label' => 'Obras',
		'type' => 'artwork',
		'options' => array_values(array_map(function ($artwork) {
			$detail = '';

			if ($artwork->artist->count()) {
				foreach ($artwork->artist as $artist) {
					$detail .= "{$artist->name} {$artist->surname}, ";
				}
			} else {
				$detail .= 'Anónimo, ';
			}

			$detail .= $artwork->year;

			return [
				'label' => $artwork->title,
				'value' => $this->url('artwork-permalink', ['slug' => $artwork->slug])->getPath(),
				'detail' => $detail,
				'foreground' => $artwork->foregroundColor,
				'background' => $artwork->backgroundColor,
				'img' => $this->img($artwork->imageFile, 'resizeCrop,80,80')->getPath(),
			];
		}, $artworks->toArray(false)))
	];
}

if ($reportages->count()) {
	$suggestions[] = [
		'label' => 'Artículos',
		'type' => 'reportage',
		'options' => array_values(array_map(function ($reportage) {
			return [
				'label' => $reportage->title,
				'detail' => $reportage->subtitle,
				'value' => $this->url('reportage-permalink', ['slug' => $reportage->slug])->getPath(),
				'img' => $this->img($reportage->imageFile, 'resizeCrop,80,80')->getPath(),
			];
		}, $reportages->toArray(false)))
	];
}

if ($movements->count()) {
	$suggestions[] = [
		'label' => 'Movimientos',
		'type' => 'movement',
		'options' => array_values(array_map(function ($movement) {
			return [
				'label' => $movement->name,
				'value' => $this->url('movement-permalink', ['slug' => $movement->slug])->getPath(),
				'img' => $this->img($movement->imageFile, 'resizeCrop,80,80')->getPath(),
			];
		}, $movements->toArray(false)))
	];
}

if ($techniques->count()) {
	$suggestions[] = [
		'label' => 'Técnicas',
		'type' => 'technique',
		'options' => array_values(array_map(function ($technique) {
			return [
				'label' => $technique->name,
				'value' => $this->url('technique-permalink', ['slug' => $technique->slug])->getPath(),
				'img' => $this->img($technique->imageFile, 'resizeCrop,80,80')->getPath(),
			];
		}, $techniques->toArray(false)))
	];
}

if ($countries->count()) {
	$suggestions[] = [
		'label' => 'Países',
		'type' => 'country',
		'options' => array_values(array_map(function ($country) {
			return [
				'label' => $country->name,
				'value' => $this->url('country-permalink', ['slug' => $country->slug])->getPath(),
				'img' => $this->img($country->imageFile, 'resizeCrop,80,80')->getPath(),
			];
		}, $countries->toArray(false)))
	];
}

if ($tags->count()) {
	$suggestions[] = [
		'label' => 'Etiquetas',
		'type' => 'tag',
		'options' => array_values(array_map(function ($tag) {
			return [
				'label' => $tag->name,
				'value' => $this->url('tag-permalink', ['slug' => $tag->slug])->getPath(),
			];
		}, $tags->toArray(false)))
	];
}

if ($museums->count()) {
	$suggestions[] = [
		'label' => 'Museos',
		'type' => 'museum',
		'options' => array_values(array_map(function ($museum) {
			return [
				'label' => $museum->name,
				'detail' => $museum->city->name,
				'value' => $this->url('museum-permalink', ['slug' => $museum->slug])->getPath(),
			];
		}, $museums->toArray(false)))
	];
}

echo json_encode($suggestions);
