<?php
use FormManager\Form;
use FormManager\Inputs\Input;
use FormManager\Fields\Field;
use FormManager\Fieldsets\Fieldset;

include('FormManager/autoloader.php');

class MyForm extends Form {
	public function __construct () {
		$this->attr([
			'action' => 'test.php',
			'method' => 'post'
		]);

		$this->add([
			'name' => Field::text()->maxlength(50)->required()->label('Your name')->val('Ola'),
			'dni' => Field::text()->pattern('[\d]{8}[\w]')->label('DNI'),
			'search' => Field::search()->label('What are you looking for?'),
			'website' => Field::url()->label('Your website')->required(),
			'comment' => Field::textarea()->label('A comment')->maxlength(30)->sanitize(function ($value) {
				return strip_tags($value);
			}),
			'email' => Field::email()->label('Your email'),
			'age' => Field::number()->min(5)->max(110)->label('How old are you?'),
			'pirolas' => Fieldset::generic()->add([
				'nome' => Field::text()->label('Nome')
			])
		]);

		/*
		$this->addFieldset([
			'height' => Field::range()->min(50)->max(220)->label('How height are you?'),
			'telephone' => Field::tel()->label('Telephone number'),
			'is-happy' => Field::checkbox()->label('Are you happy?'),
			'gender' => Field::select()->options(array(
				'm' => 'Male',
				'f' => 'Female'
			))->label('Gender'),
			'color' => Field::Radios()->options([
				'red' => 'Red',
				'green' => 'Green',
				'blue' => 'Blue'
			]),
			'color' => Field::Duplicable()->inputs([
				'red' => 'Red',
				'green' => 'Green',
				'blue' => 'Blue'
			]),
			'update' => Field::button()->type('submit')->html('Update data'),
		]);

		$this->addDuplicableFieldset([
		]);
		*/
	}
}

$Form = new MyForm;

if ($_POST) {
	$Form->load($_GET, $_POST, $_FILES);

	if ($Form->isValid()) {
		print_r($Form->val());
	} else {
		echo 'There was an error';
	}
}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		
		<title>Form manager tests</title>
		<style type="text/css">
			body {
				font-family: sans-serif;
			}
		</style>
	</head>

	<body>
		<?php echo $Form; ?>
	</body>
</html>
