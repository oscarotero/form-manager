<?php
namespace FormManager;

interface InputInterface {
	public function __toString ();

	public function attr ($name, $value = null);

	public function removeAttr ($name);

	public function load ($value = null);

	public function val ($value = null);

	public function isValid ();
}
