<?php
namespace FormManager\Input;

use FormManager\Input;

class Checkbox extends Input {
	protected $attributes = array('type' => 'checkbox');
        protected $display_order = 'reverse';
}
