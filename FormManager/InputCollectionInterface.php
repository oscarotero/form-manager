<?php
namespace FormManager;

interface InputCollectionInterface extends CommonInterface {
	public function load ($value = null, $file = null);

	public function val ($value = null);

	public function isValid ();

	public function add (array $inputs);

	public function getParent ();

	public function setParent (CommonInterface $parent);

	public function setKey ($key);

	public function getKey ();
}
