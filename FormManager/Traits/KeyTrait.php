<?php
namespace FormManager\Traits;

trait KeyTrait {
	protected $key;

	public function setKey ($key) {
		$this->key = $key;
	}

	public function getKey () {
		return $this->key;
	}

	public function getKeys () {
		if (!$key = $this->getKey()) {
			return [];
		}

		$parent = $this;
		$keys = [$key];

		while (($parent = $parent->getParent()) && ($key = $parent->getKey())) {
			$keys[] = $key;
		}

		return $keys;
	}
}
