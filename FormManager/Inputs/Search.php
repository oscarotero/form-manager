<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Search extends Input implements InputInterface {
	protected $attributes = ['type' => 'search'];
}
