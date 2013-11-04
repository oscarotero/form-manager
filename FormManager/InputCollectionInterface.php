<?php
namespace FormManager;

interface InputCollectionInterface extends CommonInterface {
	public function load ($value = null, $file = null);

	public function add (array $inputs);

	public function getParent ();

	public function setParent (CommonInterface $parent);
}
