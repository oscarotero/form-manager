<?php
namespace FormManager\Fields;

use FormManager\InputInterface;
use FormManager\Inputs\Input;

class Radio extends Field implements InputInterface {
	public function __construct () {
		$this->input = Input::radio();
	}

	public function toHtml () {
		if ($this->render) {
			$render = $this->render;

			return $render($this);
		}

		$label = isset($this->label) ? (string)$this->label : '';
		
		return "{$this->input} {$label} {$this->errorLabel}";
	}
}
