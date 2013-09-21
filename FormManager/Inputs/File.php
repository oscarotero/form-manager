<?php
namespace FormManager\Inputs;

class File extends Input implements InputInterface {
	protected $attributes = ['type' => 'file'];

	public function load ($value = null, $file = null) {
		parent::load($file);
	}
}
