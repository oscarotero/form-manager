<?php
require __DIR__.'/src/autoloader.php';

use FormManager\Form;
use FormManager\Inputs\Input;

$form = new FormManager\Form();

//$form = new Form();

$form->add([
	'nome' => Input::text()->label('O teu nome'),
	'apelido' => Input::text()->label('O teu apelido'),
	'idade' => Input::select()
		->options([
			1 => 'Menor de idade',
			2 => 'Maiore de idade'
		])
		->label('Idade')
		->render(function ($input) {
			return '<p>'.$input.'</p>';
		}),
	'enviar' => Input::submit()->html('Enviar')
]);

$form->loadFromGlobals();

echo $form;
