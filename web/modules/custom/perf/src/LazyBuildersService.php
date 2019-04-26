<?php

namespace Drupal\perf;

/**
 * Class LazyBuildersService..
 *
 * @package Drupal\perf
 */
class LazyBuildersService {

	public function page($userName) {
		return [
			'#markup' => 'Your name is '.$userName ,
		];
	}
}