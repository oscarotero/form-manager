<?php
require __DIR__.'/src/autoloader.php';

use FormManager\Builder as F;

$form = F::Form([
	'nome' => F::text()->label('O teu nome'),
	'apelido' => F::text()->label('O teu apelido'),
	'idade' => F::select()
		->options([
			1 => 'Menor de idade',
			2 => 'Maiore de idade'
		])
		->label('Idade')
		->render(function ($input) {
			return '<p>'.$input.'</p>';
		}),
	'data' => F::group([
		'dia' => F::number()->label('Dia'),
		'mes' => F::number()->label('Mes'),
	]),
	'colores' => F::choose([
		'red' => F::radio()->label('Red'),
		'blue' => F::radio()->label('Blue'),
		'green' => F::radio()->label('Green'),
	]),
	'personas' => F::collection([
		'nome' => F::text()->label('Nome'),
		'apelido' => F::text()->label('Apelidos')
	]),
	'bloques' => F::collectionMultiple([
		'texto' => [
			'titulo' => F::text()->label('Titulo'),
			'texto' => F::textarea()->label('Texto')
		],
		'cita' => [
			'texto' => F::textarea()->label('Texto'),
			'autor' => F::text()->label('Autor'),
		]
	]),
	'enviar' => F::submit()->html('Enviar')
]);

$form->loadFromGlobals();
/*
$form['personas']->val([
	[
		'nome' => 'Oscar',
		'apelido' => 'Otero'
	],[
		'nome' => 'Laura',
		'apelido' => 'Rubio'
	]
]);
$form['bloques']->val([
	[
		'type' => 'texto',
		'titulo' => 'Texto do primeiro bloque',
		'texto' => 'lorem ipsum'
	],[
		'type' => 'cita',
		'autor' => 'Laura rubio',
		'texto' => 'a cita lorem ipsum'
	]
]);
*/
echo $form;
