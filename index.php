<?php
use FormManager\Form;
use FormManager\Inputs\Input;
use FormManager\Fields\Field;

include('FormManager/autoloader.php');

class MyForm extends Form {
	public function __construct () {
		$this->attr([
			'action' => 'index.php',
			'method' => 'post'
		]);

		$this->add([
			'name' => Field::text()->maxlength(50)->required()->label('Your name'),
			'email' => Field::email()->label('Your email'),
			'telephone' => Field::tel()->label('Telephone number')->data(['ola' => 'kease']),

			'gender' => Field::choose([
				'm' => Field::radio()->label('Male'),
				'f' => Field::radio()->label('Female')
			])->render(function ($inputs, $label, $errorLabel) {
				$html = '';
				
				foreach ($inputs as $input) {
					$html .= (string)$input;
				}

				return "<div>{$html} {$label} {$errorLabel}</div>";
			}),
			
			'born' => Field::collection([
				'day' => Field::number()->min(1)->max(31)->label('Day'),
				'month' => Field::number()->min(1)->max(12)->label('Month'),
				'year' => Field::number()->min(1900)->max(2013)->label('Year')
			]),

			'language' => Field::select()->options(array(
				'gl' => 'Galician',
				'es' => 'Spanish',
				'en' => 'English'
			))->label('Language'),

			'friends' => Field::duplicable([
				'name' => Field::text()->label('Name'),
				'email' => Field::email()->label('email'),
				'age' => Field::number()->label('Age')
			]),

			'action' => Field::choose([
				'save' => Field::submit()->html('Save changes'),
				'duplicate' => Field::submit()->html('Save as new value')
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
			$Form->loadFromGlobal();

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
