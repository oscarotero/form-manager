<?php
use FormManager\Form;
use FormManager\Input;

ini_set('display_errors', 'On');

function autoload ($className) {
	$className = ltrim($className, '\\');
	$fileName  = '';
	$namespace = '';
	
	if ($lastNsPos = strripos($className, '\\')) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}

	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

	if (is_file($fileName)) {
		require $fileName;
	}
}

spl_autoload_register('autoload');

class MyForm extends Form {
	public function __construct () {
		$this->attr(array(
			'action' => 'test.php'
		));

		$this->inputs(array(
			'name' => Input::text()->maxlength(50)->required()->label('Your name'),
			'dni' => Input::text()->pattern('[\d]{8}[\w]')->label('DNI'),
			'search' => Input::search()->label('What are you looking for?'),
			'comment' => Input::textarea()->label('A comment')->maxlength(30),
			'email' => Input::email()->label('Your email'),
			'website' => Input::url()->label('Your website')->required(),
			'age' => Input::number()->min(5)->max(110)->label('How old are you?'),
			'height' => Input::range()->min(50)->max(220)->label('How height are you?'),
			'telephone' => Input::tel()->label('Telephone number'),
			'is-happy' => Input::checkbox()->label('Are you happy?')->required()
		));
	}
}

$Form = new MyForm;

if ($_GET) {
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
