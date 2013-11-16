<?php
/**
 * Trait with common methods of all child elements (elements inside the form)
 */

namespace FormManager\Traits;

use FormManager\InputInterface;

trait ChildTrait {
	protected $parent;

	public function setParent (InputInterface $parent) {
		$this->parent = $parent;

		return $this;
	}

	public function getParent () {
		return $this->parent;
	}
}
