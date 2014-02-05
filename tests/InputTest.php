<?php
use FormManager\Inputs\Input;
use FormManager\Fields\Field;

include_once __DIR__.'/../FormManager/autoloader.php';

class InputTest extends PHPUnit_Framework_TestCase {
	private function genericElementTest ($input) {
		$input->name('input-name');
		$this->assertEquals('input-name', $input->attr('name'));
		$this->assertNull($input->val());

		$input->data('name', 'value');
		$this->assertEquals('value', $input->data('name'));
		$this->assertEquals(['name' => 'value'], $input->data());

		$this->assertNull($input->attr('class'));
		$input->addClass('first');
		$input->addClass('second');
		$this->assertEquals('first second', $input->attr('class'));

		$input->removeClass('second');
		$this->assertEquals('first', $input->attr('class'));
	}

	private function genericInputTest ($input, $type = null) {
		$this->assertEquals($type, $input->attr('type'));
		$this->assertEquals('', $input->closeHtml());

		$html = '<input type="'.$type.'" name="input-name" class="first" data-name="value">';
		$this->assertEquals($html, $input->toHtml());        
	}

	public function testCheckbox () {
		$input = Input::checkbox();

		$this->assertEquals('checkbox', $input->attr('type'));
	}

	public function testEmail () {
		$input = Input::email();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'email');

		//Values
		$input->val('invalid-email');
		$this->assertFalse($input->isValid());

		$input->val('valid@email.com');
		$this->assertTrue($input->isValid());
		$this->assertEquals('valid@email.com', $input->val());
	}

	public function testFile () {
		$input = Input::file();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'file');
	}

	public function testHidden () {
		$input = Input::hidden();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'hidden');
	}

	public function testNumber () {
		$input = Input::number();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'number');

		//Values
		$input->val('not a number');
		$this->assertFalse($input->isValid());

		$input->val('25');
		$this->assertTrue($input->isValid());
		$this->assertEquals('25', $input->val());

		$input->val('25.5');
		$this->assertTrue($input->isValid());

		$input->val('');
		$this->assertTrue($input->isValid());

		$input->val('0');
		$this->assertTrue($input->isValid());

		$input->min(0);
		$this->assertTrue($input->isValid());
	}

	public function testPassword () {
		$input = Input::password();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'password');
	}

	public function testRadio () {
		$input = Input::radio();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'radio');

		//Check/uncheck
		$this->assertNull($input->attr('checked'));
		
		$input->check();
		$this->assertTrue($input->attr('checked'));
		
		$input->uncheck();
		$this->assertNull($input->attr('checked'));
	}

	public function testRange () {
		$input = Input::range();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'range');

		//Values
		$input->val('not a number');
		$this->assertFalse($input->isValid());

		$input->val('25');
		$this->assertTrue($input->isValid());

		$input->min(5)->max(10);
		$this->assertFalse($input->isValid());

		$input->val(5);
		$this->assertTrue($input->isValid());

		$input->val(10);
		$this->assertTrue($input->isValid());

		$input->val(10.1);
		$this->assertFalse($input->isValid());
	}

	public function testSearch () {
		$input = Input::search();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'search');
	}

	public function testSelect () {
		$input = Input::select();

		$this->genericElementTest($input);

		$this->assertNull($input->attr('type'));

		//Values
		$input->options([
			1 => 'One',
			2 => 'Two'
		]);

		$input->val('three');
		$this->assertFalse($input->isValid());

		$input->val('One');
		$this->assertFalse($input->isValid());

		$input->val('1');
		$this->assertTrue($input->isValid());

		$input->allowNewValues();
		$input->val('new-value');
		$this->assertTrue($input->isValid());
	}

	public function testSubmit () {
		$input = Input::submit();

		$this->genericElementTest($input);

		$this->assertEquals('submit', $input->attr('type'));
	}

	public function testTel () {
		$input = Input::tel();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'tel');
	}

	public function testText () {
		$input = Input::text();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'text');

		//Validators
		$input->maxlength(5);

		$input->val('String');
		$this->assertFalse($input->isValid());

		$input->val('Strin');
		$this->assertTrue($input->isValid());

		$input->required();

		$input->val('');
		$this->assertFalse($input->isValid());

		$input->val('0');
		$this->assertTrue($input->isValid());

		$input->pattern('[0-9]');
		
		$this->assertTrue($input->isValid());

		$input->val('nn');

		$this->assertFalse($input->isValid());
	}

	public function testTextarea () {
		$input = Input::textarea();

		$this->genericElementTest($input);

		$this->assertNull($input->attr('type'));
	}

	public function testUrl () {
		$input = Input::url();

		$this->genericElementTest($input);
		$this->genericInputTest($input, 'url');

		//Values
		$input->val('invalid-url');
		$this->assertFalse($input->isValid());

		$input->val('http://valid-url.com');
		$this->assertTrue($input->isValid());
		$this->assertEquals('http://valid-url.com', $input->val());
	}
}
