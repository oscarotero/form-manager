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

A field is an object that include an input with its label. It may also generate an extra label with the error message.

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

Create a fieldset
-----------------

A fieldset is a collection of fields or inputs with the same namespace. Its like a field with subfields.
There are various types of fieldsets:

#### Generic

The more common fieldset. Stores a collection of inputs with different names

```php
use FormManager\Fieldsets\Fieldset;
use FormManager\Fields\Field;

//Create a generic fielset
$fieldset = Fieldset::generic();

//Add some fields
$fieldset->add([
	'name' => Field::text(),
	'age' => Field::number()
]);

//Access to the fields individually
$nameInput = $fieldset['name'];

//Add more fields dinamically
$fieldset['email'] = Field::email()->required()->label('Please, insert your email here');

//Set values
$fieldset->val([
	'name' => 'Antonio',
	'age' => 31,
	'email' => 'antonio@email.com'
]);

//Get values
$values = $fieldset->val();

echo $values['email'];

//Set attributes to the fieldset
$fieldset->class('my-fieldset');
```

#### Choose

Stores a collection of inputs with the same name. Useful for radio or checkboxes inputs or to define varios submits buttons with the same name and different values.

```php
use FormManager\Fieldsets\Fieldset;
use FormManager\Fields\Field;

//Create a choose fielset
$colors = Fieldset::generic()->name('colors');

//Add some fields. The keys are the values
$colors->add([
	'red' => Field::radio()->label('Red'),
	'blue' => Field::radio()->label('Blue'),
	'green' => Field::radio()->label('Green')
]);

//Access to the fields individually
$redRadio = $colors['red'];

//Add more fields dinamically
$colors['yellow'] = Field::radio()->label('Label');

//Set value
$colors->val('red');

//Get values
$color = $colors->val();
```


Create a form
-------------

Let's put all together

```php
use FormManager\Form;
use FormManager\Fields\Field;
use FormManager\Fields\Fieldset;

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

//You can also add new inputs using the array syntax (the key will be the input name):
$MyForm = new MyForm();

$MyForm['new-input'] = Input::range()->min(0)->max(100);

//Print the form
echo $MyForm;

//Access to the inputs using key names
echo $MyForm['website'];

//Or inputs inside fieldsets
echo $MyForm['personal-info']['name'];
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
