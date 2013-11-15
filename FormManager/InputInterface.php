<?php
/**
 * Interface used by all elements (forms, fields, inputs, etc) to keep the basic behaviour
 */

namespace FormManager;

interface InputInterface {
	public function load ($value = null, $file = null);

	public function val ($value = null);

	public function isValid ();

	public function error ($error = null);
	
	public function id ($id = null);

	public function sanitize (callable $sanitizer);
}
