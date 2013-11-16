<?php
/**
 * Trait with common method for collection objects (objects having children)
 */
namespace FormManager\Traits;

use FormManager\Form;
use FormManager\CollectionInterface;

trait CollectionTrait {
	protected $children = [];
	protected $sanitizer;
	protected $error;

	public function __clone () {
		foreach ($this->children as $key => $child) {
			$this->children[$key] = clone $child;
			$this->children[$key]->setParent($this);
		}
	}

	//Iterator interface methods:
	public function rewind () {
		return reset($this->children);
	}

	public function current () {
		return current($this->children);
	}

	public function key () {
		return key($this->children);
	}

	public function next () {
		return next($this->children);
	}

	public function valid () {
		return key($this->children) !== null;
	}

	//ArrayAccess interface methods
	public function offsetSet ($offset, $value) {
		if ($offset === null) {
			throw new \InvalidArgumentException('You must define a key to every element added');
		}

		$this->add($offset, $value);
	}

	public function offsetExists ($offset) {
		return isset($this->children[$offset]);
	}

	public function offsetUnset ($offset) {
		unset($this->children[$offset]);
	}

	public function offsetGet ($offset) {
		return isset($this->children[$offset]) ? $this->children[$offset] : null;
	}

	//Add elements
	public function add ($key, $value = null) {
		if (is_array($key)) {
			foreach ($key as $key => $value) {
				$this->children[$key] = $value->setParent($this);
				$this->prepareChild($value, $key);
			}

			return $this;
		}

		$this->children[$key] = $value->setParent($this);
		$this->prepareChild($value, $key);

		return $this;
	}


	//Input interface methods
	public function isValid () {
		foreach ($this->children as $child) {
			if (!$child->isValid()) {
				return false;
			}
		}

		return true;
	}

	public function val ($value = null) {
		if ($value === null) {
			$value = [];

			foreach ($this->children as $key => $child) {
				$value[$key] = $child->val();
			}

			return $value;
		}

		foreach ($this->children as $key => $child) {
			$child->val(isset($value[$key]) ? $value[$key] : null);
		}

		return $this;
	}

	public function load ($value = null, $file = null) {
		if (($sanitizer = $this->sanitizer) !== null) {
			$value = $sanitizer($value);
		}

		foreach ($this->children as $key => $child) {
			$child->load(
				isset($value[$key]) ? $value[$key] : null,
				isset($file[$key]) ? $file[$key] : null
			);
		}

		return $this;
	}

	public function sanitize (callable $sanitizer) {
		$this->sanitizer = $sanitizer;

		return $this;
	}

	public function error ($error = null) {
		if ($error === null) {
			return $this->error;
		}

		$this->error = $error;

		return $this;
	}

	public function prepareChildren ($parentPath = null) {
		foreach ($this->children as $key => $child) {
			$this->prepareChild($child, $key, $parentPath);
		}
	}

	public function prepareChild ($child, $key, $parentPath = null) {
		$path = $parentPath ? "{$parentPath}[{$key}]" : $key;

		if ($child instanceof CollectionInterface) {
			$child->prepareChildren($path);
		} else {
			$child->attr('name', $path);
		}
	}

	public function childrenToHtml () {
		$html = '';

		foreach ($this->children as $child) {
			$html .= (string)$child;
		}

		return $html;
	}
}
