FormManager
===========

Created by Oscar Otero <http://oscarotero.com> <oom@oscarotero.com>

GNU Affero GPL version 3. http://www.gnu.org/licenses/agpl-3.0.html

Requirements:

* PHP 5.4
* Any PSR-0 autoloader


Create an input
---------------

```php
use FormManager\Input;

$name = Input::text();

//You can set, get or remove attributes to the input using a jQuery syntax:

$name->attr('name', 'username');

$name->attr(array(
	'maxlength' => 50,
	'required' => true
));

$maxlength = $name->attr('maxlength');

$name->removeAttr('required');

$name->val('MyName');

//Other way to add attributes:
$name->pattern('\w+')->required()->maxlength(100);


//Add a label
$name->label('Write your name');

//Manipulate the label attributes
$name->label->attr('class', 'beauty-label');

//Print the html input
echo $name;

//Print the html input with some extra attributes:
echo $name->toHtml(array('class' => 'text-input'));

//Print the input with the label
echo $name->render();

//Print the input with the label with some extra attributes
echo $name->render($inputAttr, $labelAttr, $errorLabelAttr);

//Sanitize the input data
$name->sanitize(function ($raw_data) {
	return strip_tags($raw_data);
});

//Load the data:
$name->load($_GET['name']);

//Get sanitized data:
echo $name->val();

//Validate the data
if ($name->isValid()) {
	echo 'data is valid';
} else {
	echo 'Data is invalid: '.$name->error();
}
```

Create a form
-------------

```php
use FormManager\Form;
use FormManager\Input;
use FormManager\Fieldset;

class MyForm extends Form {
	public function __construct () {
		$this->attr('action', 'test.php');

		//Add inputs
		$this->addInputs(array(
			'name' => Input::text()->maxlength(50)->required()->label('Your name'),
			'dni' => Input::text()->pattern('[\d]{8}[\w]')->label('DNI'),
			'search' => Input::search()->label('What are you looking for?'),
			'comment' => Input::textarea()->label('A comment')->maxlength(30),
			'email' => Input::email()->label('Your email'),
			'website' => Input::url()->label('Your website')->required(),
			'age' => Input::number()->min(5)->max(110)->label('How old are you?'),
			'height' => Input::range()->min(50)->max(220)->label('How height are you?'),
			'telephone' => Input::tel()->label('Telephone number'),
			'is-happy' => Input::checkbox()->label('Are you happy?')->required(),
			'gender' => Input::select()->options(array(
				'm' => 'Male',
				'f' => 'Female'
			))->label('Gender'),
            'click-me' => Input::button()->html('Click Me'),
            'submit' => Input::submit()->value('Submit')
		));
	}
}

//You can also add new inputs using the array syntax (the key will be the input name):
$MyForm = new MyForm();

$MyForm['new-input'] = Input::range()->min(0)->max(100);

//Print the form
echo $MyForm;

//Access to the inputs using key names
echo $MyForm['email']->toHtml(array('class' => 'email-input'));
```

Choose
------
Sometimes, there are inputs sharing the name (for example radio inputs or submits with different values but the same name). For these cases, there is a special input called "Choose". A Choose is a group of inputs that share the same name with different values.

```php
use FormManager\Form;
use FormManager\Input;

class MyForm extends Form {
	public function __construct () {
		$this->attr('action', 'test.php');

		$this->addInputs([
			'color' => Input::Choose([
				'red' => Input::radio()->label('Red'),
				'green' => Input::radio()->label('Green'),
				'blue' => Input::radio()->label('Blue')
			]),
			'action' => Input::Choose([
				'pants' => Input::button()->type('submit')->html('Set this color to my pants'),
				'tshirt' => Input::button()->type('submit')->html('Set this color to my T-shirt'),
				'shoes' => Input::button()->type('submit')->html('Set this color to my shoes'),
			])
		]);
	}
}

//You can access to any input in a collection using both name and value as keys:
$Form = new MyForm;

echo $Form['color']['red'];

//Or expand the collection with more inputs
$Form['color']['yellow'] = Input::radio()->label('Yellow');

//note that you have not specify the value because it get it from the key. The above code is equivalent to:
$Form['color'][] = Input::radio()->value('yellow')->label('Yellow');
```

Fieldset
--------
You can group the inputs in fieldsets.

```php
use FormManager\Form;
use FormManager\Input;
use FormManager\Fieldset;

class MyForm extends Form {
	public function __construct () {
		$this->attr('action', 'test.php');

		//Create some fieldsets
		$personalInfo = new Fieldset([
			'name' => Input::text()->maxlength(50)->required()->label('Your name'),
			'age' => Input::number()->maxlength(3)->required()->label('Your age')
		]);

		$favorites = new Fieldset([
			'colors' => Input::select()->label('Your favorite color')->options(array(
				'red' => 'Red'
				'blue' => 'Blue'
				'green' => 'Green'
			)),
			'food' => Input::text()->label('Your favorite food')
		]);

		//Change some attributes
		$favorites->attr('class', 'fancy-fieldset');

		//Add the fieldsets to the form
		$this->addFieldset($personalInfo);
		$this->addFieldset($favorites);
	}
}
```


Manage data
-----------

```php
//Load the data send by the form:

$MyForm = new MyForm();

$MyForm->load($_GET, $_POST, $_FILES);

if ($MyForm->isValid()) {
	$data = $MyForm->val();
} else {
	echo 'there are errors in the form';
}
```
