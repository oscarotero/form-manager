<?php
namespace FormManager;

trait InputCollectionTrait {
	use CollectionTrait;

	protected $parent;

	public function setParent (CommonInterface $parent) {
		$this->parent = $parent;
	}

	public function getParent () {
		return $this->parent;
	}

	public function load ($value = null, $file = null) {
		foreach ($this->inputs as $name => $input) {
			$input->load((isset($value[$name]) ? $value[$name] : null), (isset($file[$name]) ? $file[$name] : null));
		}

		return $this;
	}
}
