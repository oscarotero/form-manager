FormManager
===========

Created by Oscar Otero <http://oscarotero.com> <oom@oscarotero.com>

GNU Affero GPL version 3. http://www.gnu.org/licenses/agpl-3.0.html

Requirements:

* PHP 5.4
* Any PSR-0 autoloader (or you may include the autoloader.php file)


Create an input
---------------

```php
use FormManager\Inputs\Input;

$name = Input::text();

//Use the jQuery syntax to set, get or remove attributes:

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

//Print the html input
echo $name;

//Print the html input adding extra attributes:
echo $name->class('text-input')->placeholder('Your name');

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

Create a field
--------------

A field is an object that include the input and its label. It may also generate an extra label with the error message.

```php
use FormManager\Fields\Field;

$name = Field::text();

//The API to modify the input is the same:
$name->required()->maxlength(100);

//But you can also define a label
$name->label('User name');

//And modify the label:
$name->label->class('main-label');

//Print the field (label + input and, optionally, the label-error)
echo $name;

//Print the pieces individually:
echo $name->label.' - '.$name->input.' - '.$name->labelError;
```


Create a form
-------------

Let's put all together

```php
use FormManager\Form;
use FormManager\Fields\Field;

class MyForm extends Form {
	public function __construct () {
		$this->attr([
			'action' => 'test.php',
			'method' => 'post'
		]);

		//Add fields
		$this->add([
			'name' => Field::text()->maxlength(50)->required()->label('Your name'),
			'dni' => Field::text()->pattern('[\d]{8}[\w]')->label('DNI'),
			'search' => Field::search()->label('What are you looking for?'),
			'comment' => Field::textarea()->label('A comment')->maxlength(30),
			'email' => Field::email()->label('Your email'),
			'website' => Field::url()->label('Your website')->required(),
			'age' => Field::number()->min(5)->max(110)->label('How old are you?'),
			'height' => Field::range()->min(50)->max(220)->label('How height are you?'),
			'telephone' => Field::tel()->label('Telephone number'),
			'is-happy' => Field::checkbox()->label('Are you happy?')->required(),
			'language' => Field::select()->options(array(
				'gl' => 'Galician',
				'es' => 'Spanish',
				'en' => 'English'
			))->label('Gender'),
			'gender' => Field::radios()->options(array(
				'm' => 'Male',
				'f' => 'Female'
			)),
            'click-me' => Field::button()->html('Click Me'),
            'submit' => Field::submit()->value('Submit')
		]);
	}
}

//You can also add new inputs using the array syntax (the key will be the input name):
$MyForm = new MyForm();

$MyForm['new-input'] = Input::range()->min(0)->max(100);

//Print the form
echo $MyForm;

//Access to the inputs using key names
echo $MyForm['email'];
```

Fieldset
--------
You can group the fields into fieldsets.

```php
use FormManager\Form;
use FormManager\Fields\Field;
use FormManager\Fieldsets\Fieldset;

class MyForm extends Form {
	public function __construct () {
		$this->attr('action', 'test.php');

		//Create a fieldset
		$this->addFieldset([
			'colors' => Input::select()->label('Your favorite color')->options(array(
				'red' => 'Red'
				'blue' => 'Blue'
				'green' => 'Green'
			)),
			'food' => Input::text()->label('Your favorite food')
		]);

		//Add some fields out of the fieldset
		$this->add([
			'name' => Input::text()->maxlength(50)->required()->label('Your name'),
			'age' => Input::number()->maxlength(3)->required()->label('Your age')
		]);
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
