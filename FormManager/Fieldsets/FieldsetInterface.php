<?php
namespace FormManager\Fieldsets;

use FormManager\Form;

interface FieldsetInterface extends \Iterator, \ArrayAccess {
	public function __construct (Form $form);

	public function add (array $inputs);

	public function __toString ();
}
