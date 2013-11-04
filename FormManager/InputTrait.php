<?php
namespace FormManager;

trait InputTrait {
	protected $parent;
	protected $key;

	public function setParent (CommonInterface $parent) {
		$this->parent = $parent;
	}

	public function getParent () {
		return $this->parent;
	}

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
