<?php
namespace FormManager\Traits;

use FormManager\CommonInterface;

trait PropagateTrait {
	use KeyTrait;

	protected $parent;

	public function setParent (CommonInterface $parent) {
		$this->parent = $parent;
	}

	public function getParent () {
		return $this->parent;
	}

	public function generateName () {
		if ($keys = $this->getKeys()) {
			$name = array_pop($keys);

			while ($keys) {
				$name .= '['.array_pop($keys).']';
			}

			$this->attr('name', $name);
		}
	}
}
