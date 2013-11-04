<?php
namespace FormManager;

interface InputInterface extends CommonInterface {
	public function load ($value = null, $file = null);

	public function error ($error = null);
	
	public function id ($id = null);

	public function sanitize (callable $sanitizer);

	public function getParent ();

	public function setParent (CommonInterface $parent);
}
