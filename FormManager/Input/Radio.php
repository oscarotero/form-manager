<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Radio extends Input implements InputInterface {
	protected $attributes = array('type' => 'radio');
	protected $label_position = Input::LABEL_POSITION_AFTER;
}
