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

#### Collection field

A collection is a special field that can contain other fields or inputs:

```php
use FormManager\Fields\Field;

$date = Field::collection([
	'day' => Field::number()->min(1)->max(31)->label('Day'),
	'month' => Field::number()->min(1)->max(12)->label('Month'),
	'year' => Field::number()->min(1900)->max(2013)->label('Year')
]);

//You can add also a global label for this collection
$date->label('Your birth day');

//Add some data
$date->val([
	'day' => 21,
	'month' => 6,
	'year' => 1979
]);

//Access to the fields individually
$year = $date['year']->val();

//Add more fields dinamically
$date['hour'] = Field::number()->min(0)->max(23)->label('Hour');


//Get values
$values = $date->val();

echo $values['year'];
```

#### Choose

Another special field that contains fields with the same name but different values. Useful for radio inputs or to define varios submits buttons.

```php
use FormManager\Fields\Field;

//Create a choose field
$colors = Field::choose()->name('colors');

//Add some fields. The keys will be the values
$colors->add([
	'red' => Field::radio()->label('Red'),
	'blue' => Field::radio()->label('Blue'),
	'green' => Field::radio()->label('Green')
]);

//Access to the fields individually
$radio = $colors['red'];

//Add more fields dinamically
$colors['yellow'] = Field::radio()->label('Label');

//Set value
$colors->val('red');

//Get values
$color = $colors->val();
```

#### Duplicable

Stores a collection of inputs that you can clone them for multiple values.

```php
use FormManager\Fields\Field;

//Create a multiple field
$people = Field::duplicate([
	'name' => Field::text()->label('Name'),
	'email' => Field::email()->label('email'),
	'age' => Field::number()->label('Age')
]);

//Set values
$people->val([
	[
		'name' => 'Xaquín',
		'email' => 'xaquin@email.com',
		'age' => '24'
	],[
		'name' => 'Uxío',
		'email' => 'uxio@email.com',
		'age' => '37'
	]
]);

//Get fieldsets by number
echo $people[0]['name']->val(); //returns 'Xaquín'

//Append a new empty duplicate
$people->addDuplicate();

//Access to the new duplicated fields
$people[1]['name']->val('Manoel');
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

		$this->add([
			'name' => Field::text()->maxlength(50)->required()->label('Your name'),
			'email' => Field::email()->label('Your email'),
			'telephone' => Field::tel()->label('Telephone number'),

			'gender' => Field::choose([
				'm' => Field::radio()->label('Male'),
				'f' => Field::radio()->label('Female')
			]),
			
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

			'friends' => Field::duplicate([
				'name' => Field::text()->label('Name'),
				'email' => Field::email()->label('email'),
				'age' => Field::number()->label('Age')
			])->addDuplicate(),

			'action' => Field::choose([
				'save' => Field::submit()->html('Save changes'),
				'duplicate' => Field::submit()->html('Save changes')
			])
		]);
	}
}

//You can also add new inputs using the array syntax (the key will be the input name):
$MyForm = new MyForm();

$MyForm['new-input'] = Input::range()->min(0)->max(100);

//Print the form
echo $MyForm;

//Access to the fields using key names
echo $MyForm['website'];

//Or fields inside fields
echo $MyForm['born']['day'];
```


Manage data
-----------

```php
//Load the data send by the form:

$MyForm = new MyForm();

$MyForm->loadFromGlobals();

if ($MyForm->isValid()) {
	$data = $MyForm->val();
} else {
	echo 'there are errors in the form';
}

//You can set the global values:
$MyForm->loadFromGlobals($_GET, $_POST, $_FILES);

//Or load your custom values (like any other field or input)
$MyForm->load($array_values);
```
