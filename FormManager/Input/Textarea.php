<?php
namespace FormManager\Input;

use FormManager\Input;

class Textarea extends Input {
	protected $attributes = array('type' => 'text');
	protected $value;

	public function val ($value = null) {
		if ($value === null) {
			return $this->value;
		}

		$this->value = $value;

		return $this;
	}

	public function toHtml (array $attributes = array()) {
		if ($this->error) {
			if (isset($attributes['class'])) {
				$attributes['class'] .= ' error';
			} else {
				$attributes['class'] = 'error';
			}

			$html = '<textarea'.$this->attrToHtml($attributes).'>'.$this->value.'</textarea>';
			$html .= '<label class="error">'.$this->error.'</label>';
		} else {
			$html = '<textarea'.$this->attrToHtml($attributes).'>'.$this->value.'</textarea>';
		}

		return $html;
	}
}
