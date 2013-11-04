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

		//Add inputs, fields or fieldsets
		$this->add([
			'personal-info' => Fieldset::generic([
				'name' => Field::text()->maxlength(50)->required()->label('Your name'),
				'dni' => Field::text()->pattern('[\d]{8}[\w]')->label('DNI'),
				'email' => Field::email()->label('Your email'),
				'age' => Field::number()->min(5)->max(110)->label('How old are you?'),
				'telephone' => Field::tel()->label('Telephone number'),
			]),

			'search' => Field::search()->label('What are you looking for?'),
			'comment' => Field::textarea()->label('A comment')->maxlength(30),
			'website' => Field::url()->label('Your website')->required(),
			'height' => Field::range()->min(50)->max(220)->label('How height are you?'),
			'is-happy' => Field::checkbox()->label('Are you happy?')->required(),

			'language' => Field::select()->options(array(
				'gl' => 'Galician',
				'es' => 'Spanish',
				'en' => 'English'
			))->label('Gender'),

			'gender' => Fieldset::choose([
				'm' => Field::radio()->label('Male'),
				'f' => Field::radio()->label('Female')
			]),

			'action' => Fieldset::choose([
				'save' => Field::submit()->html('Save changes'),
				'duplicate' => Field::submit()->value('Save as new value')
			])
		]);
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
		<?php
		$Form = new MyForm;

		if ($_POST) {
			$Form->load($_GET, $_POST, $_FILES);

			echo '<pre>';
			if (!$Form->isValid()) {
				echo 'There was an error';
			} else {
				print_r($Form->val());
			}
			echo '</pre>';
		}
		
		echo $Form;
		?>
	</body>
</html>
