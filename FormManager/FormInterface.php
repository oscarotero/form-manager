<?php
namespace FormManager;

use FormManager\Form;

interface FormInterface extends CommonInterface {
	public function load (array $get = array(), array $post = array(), array $file = array());

	public function val ($value = null);

	public function isValid ();

	public function setKey ($key);

	public function getKey ();
}
