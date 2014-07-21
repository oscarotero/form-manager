<?php
/**
 * Interface used by all collection elements
 */

namespace FormManager;

interface CollectionInterface extends InputInterface {

	/**
	 * Prepare a child element before insert
	 * 
	 * @param InputInferface $child
	 * @param string         $key        The key used to append this child (the input name)
	 * @param null|string    $parentPath The full parent path (the parents names)
	 */
	public function prepareChild ($child, $key, $parentPath = null);


	/**
	 * Prepare the children before insert
	 * 
	 * @param null|string $parentPath The full parent path (the parents names)
	 */
	public function prepareChildren ($parentPath = null);
}
