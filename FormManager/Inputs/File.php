<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class File extends Input implements InputInterface {
	protected $attributes = ['type' => 'file'];

	/**
     * {@inheritDoc}
     */
	public function load ($value = null, $file = null) {
		parent::load($file);
	}
}
