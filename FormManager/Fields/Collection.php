<?php
namespace FormManager\Fields;

use FormManager\Traits\ChildTrait;
use FormManager\Traits\CollectionTrait;

use FormManager\Label;
use FormManager\CollectionInterface;

use Iterator;
use ArrayAccess;

class Collection implements Iterator, ArrayAccess, CollectionInterface {
	use ChildTrait, CollectionTrait {
		CollectionTrait::__clone as private __collectionClone;
	}

	public function __construct (array $children = null) {
		if ($children) {
			$this->add($children);
		}
	}

	public function __toString () {
		return $this->toHtml();
	}

	public function __clone () {
		$this->__collectionClone();

		if (isset($this->label)) {
			$this->label = clone $this->label;
		}
	}

	public function __get ($name) {
		if ($name === 'label') {
			return $this->label = new Label();
		}

		if (($name === 'errorLabel') && ($error = $this->error())) {
			return new Label(null, ['class' => 'error'], $error);
		}
	}

	public function label ($html = null) {
		if ($html === null) {
			return $this->label->html();
		}

		$this->label->html($html);

		return $this;
	}

	public function error ($error = null) {
		if ($error === null) {
			return $this->error;
		}

		$this->error = $error;

		return $this;
	}

	public function id ($id = null) {
		if ($id === null) {
			if (empty($this->attributes['id'])) {
				$this->attributes['id'] = uniqid('id_', true);
			}

			return $this->attributes['id'];
		}

		$this->attributes['id'] = $id;

		return $this;
	}

	public function toHtml () {
		$label = isset($this->label) ? (string)$this->label : '';
		$html = $this->childrenToHtml();

		return "{$label} {$html} {$this->errorLabel}";
	}
}
