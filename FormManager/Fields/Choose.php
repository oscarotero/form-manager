<?php
namespace FormManager\Fields;

use FormManager\CollectionInterface;

class Choose extends Collection implements CollectionInterface {

	public function prepareChild ($child, $key, $parentPath = null) {
		if ($child instanceof CollectionInterface) {
			throw new \Exception("The Choose field cannot have collections inside", 1);
		}

		$child->val($key);
		$child->attr('name', $parentPath);
	}
}
