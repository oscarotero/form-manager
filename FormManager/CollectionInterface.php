<?php
/**
 * Interface used by all collection elements
 */

namespace FormManager;

interface CollectionInterface extends InputInterface {
	public function prepareChild ($child, $key, $parentPath = null);

	public function prepareChildren ($parentPath = null);
}
