<?php
namespace FormManager;

use FormManager\Form;

interface InputInterface {
	public function __toString ();

	public function setForm (Form $form);

	public function error ($error = null);
	
	public function id ($id = null);

	public function attr ($name = null, $value = null);

	public function removeAttr ($name);

	public function sanitize (callable $sanitizer);

	public function load ($value = null, $file = null);

	public function val ($value = null);

	public function isValid ();
}
