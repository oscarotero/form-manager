<?php
namespace FormManager;

use FormManager\Form;

interface FormInterface extends CommonInterface {
	public function load (array $get = array(), array $post = array(), array $file = array());
}
