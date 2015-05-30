# FormManager

[![Build Status](https://travis-ci.org/oscarotero/form-manager.png?branch=master)](https://travis-ci.org/oscarotero/form-manager)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oscarotero/form-manager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oscarotero/form-manager/?branch=master)

Created by Oscar Otero <http://oscarotero.com> <oom@oscarotero.com>

## Installation:

This package needs php>=5.4 and is available on [Packagist](https://packagist.org/packages/form-manager/form-manager):

```
composer require form-manager/form-manager
```

## Usage

### Namespace import

FormManager is namespaced, but you only need to import a single class into your context:

```php
use FormManager\Builder as F;
```

### Create a field

All HTML5 field types are supported.

```php
//Create an input type="text" element
$name = F::text();

//Use the jQuery syntax to set/get/remove attributes:
$name->attr('name', 'username');

$name->attr([
	'maxlength' => 50,
	'required' => true
]);

$maxlength = $name->attr('maxlength');

$name->removeAttr('required');

//Get/set values
$name->val('MyName');

//Get/set css classes
$name->addClass('cool-input');
$name->removeClass('cool-input');

//Get/set/remove data-* attributes
$name->data('id', 23);
$name->data([
	'name' => 'value',
	'foo' => 'bar'
]);
$foo = $name->data('foo');

$name->removeData('id');

$name->removeData(); //Remove all data

//You can chain various methods:
$email = F::email()->addClass('cool-input')->id('my-email')->val('my@email.com');

//And use the __call() magic method to add attributes:
$email->required(); //same than $email->attr('required', true);
$email->required(false); //same than $email->attr('required', false);
```

### Generate the html code

The html code is created automatically on convert the object into a string:

```php
$name = F::text()->class('my-input')->required();

echo $name; //<input type="text" class="my-input" required>

//print the input with extra attributes
echo $name->addClass('text-input')->placeholder('Your name');

//You can customize the render function:
$name->render(function($input)
{
	return '<div class="field">'.$input.'</div>';
});
```

### Working with data

Inputs can validate the data depending of the type and other validation attributes:

```php
$url = F::url();

//Set the input as required
$url->required();

//Check if the value is valid
if (!$url->isValid()) {
	echo $url->error(); //This value is required
}

//set an invalid url
$url->val('invalid-url');

//check the value and get the error
if (!$url->isValid()) {
	echo $url->error(); //This value is not a valid url
}
```

The inputs can handle custom validators:
```php
$name = F::text();

function isDave($input)
{
	if ($input->val() !== 'dave') {
		throw new FormManager\InvalidValueException('This value must be "dave"');
	}
}

//Add custom validators
$name->addValidator('isDave');

$name->val('tom');

if (!$name->isValid()) {
	echo $name->error(); //This value must be "dave"
}

//Remove the validator
$name->removeValidator('isDave');
```

The `load()` method is like `val()` but it handles the data sent by the client:

```php
$name = F::text();

//Add a function to sanitize the data
$name->sanitize(function($value)
{
	return strip_tags($value);
});

//if you use val(), the value remains as is
$name->val('<strong>earl</strong>');
echo $name->val(); //<strong>earl</strong>

//if you use load(), the value will be sanitized
$name->load('<strong>earl</strong>');
echo $name->val(); //earl
```


### Labels

You can use labels with your inputs, just use the property `->label` and it will be created automatically. It may also generate an extra label with the error message.

```php
$name = F::text();

//Define a label
$name->label('User name');

//And modify the label using the same syntax than inputs:
$name->label->class('main-label');

//Print all (label + input)
echo $name;

//Print label and inputs separately
echo $name->label . '<br>' . $name->input;
```

## Containers

Containers are objects that contain other elements (fields or other containers). Technically, they are html elements (by default `<div></div>`) so they have the same methods than inputs to set/get/remove attributes.

There are various types of containers, deppending of the data scheme:

### Group

A group is a simple container to store fields/containers by name. The following example shows a group of three fields:

```php
$date = F::group([
	'day' => F::number()->min(1)->max(31)->label('Day'),
	'month' => F::number()->min(1)->max(12)->label('Month'),
	'year' => F::number()->min(1900)->max(2013)->label('Year')
]);

//Set values to group
$date->val([
	'day' => 21,
	'month' => 6,
	'year' => 1979
]);

//Get values
$values = $date->val();

//Use array syntax to access to the fields by name
$year = $date['year']->val();

//Add more fields dinamically
$date['hour'] = F::number()->min(0)->max(23)->label('Hour');

//Add other html attributes to the group:
$date->addClass('field-day')->attr(['id' => 'date-field']);
```

### Choose

This container stores fields with the same name but different values. Useful for radio inputs or to define various submit buttons.

```php
//Create a choose container
$colors = F::choose();

//Add some fields. The keys are the values
$colors->add([
	'red' => F::radio()->label('Red'),
	'blue' => F::radio()->label('Blue'),
	'green' => F::radio()->label('Green')
]);

//Access to the fields by value
$red_radio = $colors['red'];

//Add more fields dinamically
$colors['yellow'] = F::radio()->label('Yellow');

//Set the value
$colors->val('red');

//Get value
$color_choosen = $colors->val();
```

### Collection

It's like a [group](#group), but stores a collection of values:

```php
//Create a collection container
$people = F::collection([
	'name' => F::text()->label('Name'),
	'email' => F::email()->label('email'),
	'age' => F::number()->label('Age')
]);

//Set two values
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

//Access to the first group of values:
$group = $people[0];

//Access to any field
echo $people[0]['name']->val(); //returns 'Xaquín'

//Push a new value
$people->pushVal([
	'name' => 'Manoela',
	'email' => 'manoela@email.com',
	'age' => '18'
]);

//Returns the group container used as template for each value inserted.
//useful to use the html template in javascript

$template = $people->getTemplate();

echo '<div class="template">'.$template.'</div>';
```

### CollectionMultiple

If you need different types of values in your collection, CollectionMultiple is the answer:

```php
//Create a collectionMultiple container
$article = F::collectionMultiple([
	'section' => [
        'title' => F::text()->label('Title'),
        'text' => F::textarea()->label('Text')
    ],
    'picture' => [
        'caption' => F::text()->label('Caption'),
        'image' => F::file()->label('Image')
    ],
    'quote' => [
        'text' => F::textarea()->label('Text'),
        'author' => F::text()->label('Author')
    ]
]);

//Set values. Note that we need a "type" value to know the type of each row
$article->val([
	[
		'type' => 'section',
		'title' => 'This is the section title',
        'text' => 'Lorem ipsum...',
	],[
		'type' => 'quote',
		'text' => 'You have to learn the rules of the game. And then you have to play better than anyone else.',
		'author' => 'Albert Einstein'
	]
]);

// Note that a hidden input will be created for you to store the group type
$article[0]['type']->val(); //section
$article[0]['type']->attr('type'); //hidden

//Push more values
$article->pushVal([
	'type' => 'section',
	'title' => 'This is another section',
    'text' => 'The world of dogs are better than the cats because...'
]);

//Add new types
$article->add([
	'video' => [
		'title' => F::text()->label('Title'),
		'video' => F::url()->label('Youtube url')
	]
]);

//Returns an array with all templates used
$templates = $article->getTemplate();

foreach ($templates as $name => $template) {
	echo '<div class="template-'.$name.'">'.$template.'</div>';
}
```

## Loader

The main aim of the loader container is separate the way to load the data with the way to store and keep this data once it's loaded. Let's say for example, an input type file: if a file is loaded, the value is an array with the same structure than any $_FILES value, but if user doesn't upload anything, the value is empty. So, what is supposed to do in this case? remove the file or keep the previous value?
The loader container has two fields: a "loader" field and a "field" field. The first one is responsive to load the new values (for example, it can be an input type file) and the second keeps the previous value (for example, it can be an input type hidden, or text, etc). Let's see an example:

```php
$fileUpload = F::loader([
    'loader' => F::file()->label('Upload a file here'),
    'field' => F::hidden() //this hidden input stores the old value
]);

//Set a value
$fileUpload->val('my-file.png');

//we have this value
echo $fileUpload->val(); //my-file.png

//load empty data
$fileUpload->load(null);

//Nothing was loaded, so we keep the old value
echo $fileUpload->val(); //my-file.png

//load new value
$fileUpload->load($_FILES['file-upload']);

//we have the new value
echo ($fileUpload->val() === $_FILES['file-upload']); //true
```

## Forms

We need a form to put all this things together. The form is just another container, in fact, it's like a [Group](#group).

```php
$form = F::form();

//Set the form attributes:
$form->attr([
	'action' => 'test.php',
	'method' => 'post'
]);

//Add some fields and containers
$form->add([
	'name' => F::text()->maxlength(50)->required()->label('Your name'),
	'email' => F::email()->label('Your email'),
	'telephone' => F::tel()->label('Telephone number'),

	'gender' => F::choose([
		'm' => F::radio()->label('Male'),
		'f' => F::radio()->label('Female')
	]),
	
	'born' => F::group([
		'day' => F::number()->min(1)->max(31)->label('Day'),
		'month' => F::number()->min(1)->max(12)->label('Month'),
		'year' => F::number()->min(1900)->max(2013)->label('Year')
	]),

	'language' => F::select()->options(array(
		'gl' => 'Galician',
		'es' => 'Spanish',
		'en' => 'English'
	))->label('Language'),

	'friends' => F::collection([
		'name' => F::text()->label('Name'),
		'email' => F::email()->label('email'),
		'age' => F::number()->label('Age')
	]),

	'action' => F::choose([
		'save' => F::submit()->html('Save changes'),
		'duplicate' => F::submit()->html('Save changes')
	])
]);

//You can also add new fields using the array syntax (the key will be the input name):
$form['new-input'] = F::range()->min(0)->max(100)->val(50);

//Print the form
echo $form;

//Access to the fields using key names
echo $form['website'];

//Or fields inside fields
echo $form['born']['day'];

//Set the values to all fields:
$form->val([
	'name' => 'Oscar',
	'email' => 'oom@oscarotero.com',
	'gender' => 'm',
	'born' => [
		'day' => 21,
		'month' => 6,
		'year' => 1979
	],
	'language' => 'gl',
	'friends' => [
		[
			'name' => 'Friend 1',
			'email' => 'friend1@email.com',
			'age' => 25,
		],[
			'name' => 'Friend 2',
			'email' => 'friend2@email.com',
			'age' => 30,
		],[
			'name' => 'Friend 3',
			'email' => 'friend3@email.com',
			'age' => 35,
		]
	],
	'action' => 'save'
]);

//Get the values
$values = $form->val();

//To load the raw values from globals $_GET, $_POST and $_FILES:
$form->loadFromGlobals();

//Or specify your own globals
$form->loadFromGlobals($_my_GET, $_my_POST, $_my_FILES);

//Check the errors
if (!$form->isValid()) {
	echo 'there are errors in the form';
}
```

## Builder

The `Builder` class is used to ease the creation of fields and containers. For example, instead of this:

```php
use FormManager\Containers\Form;
use FormManager\Inputs\Text;
use FormManager\Inputs\Textarea;

$form = new Form([
	'name' => new Text(),
	'bio' => new Textarea(),
]);
```

You can do simply this:

```php
use FormManager\Builder as F;

$form = F::form([
	'name' => F::text(),
	'bio' => F::textarea()
]);
```

The `FormManager\Builder` handles the instantation of all theses classes for you using factories. By default, it contains the `FormManager\Factory`, responsible of instantation of all fields and containers.

But you can add your owns factories, creating classes implementing `FormManager\FactoryInterface`.

This is useful for a lot of things. For example, to create custom fields:

```php
use FormManager\Builder as F;
use FormManager\FactoryInterface;

class CustomFields implements FactoryInterface
{
	/**
	 * Method required by the interface
	 */
	public function get($name, array $arguments)
	{
		if (method_exists($this, $name)) {
			return $this->$name();
		}
	}

	public function Year()
	{
		return F::number()->min(1900)->max(date('Y'));
	}
}
```

Use it in your app:

```php
use FormManager\Builder as F;

F::addFactory(new CustomFields());

$date = F::form([
	'name' => F::text(),
	'born-year' => F::year(),
	'dead-year' => F::year(),
]);
```

Other example is save all forms of your app under a namespace:

```php
namespace MyApp\Forms;

use FormManager\Builder as F;
use FormManager\Containers\Form;

class EditUserForm extends Form
{
	public function __construct()
	{

		$this->add([
			'name' => F::text()->maxlength(200)->label('Name'),
			'email' => F::email()->label('Email'),
			'password' => F::password()->label('Password'),
			'repeat_password' => F::password()->label('Repeat password')
		]);

		//Add a validator to check the password
		$this->addValidator('password-check', function($form)
		{
			$password1 = $form['password']->val();
			$password2 = $form['repeat_password']->val();

			if ($password1 !== $password2) {
				throw new FormManager\InvalidValueException('The passwords does not match');
			}
		});
	}
}
```

And create a factory

```php
use FormManager\FactoryInterface;

class MyForms implements FactoryInterface
{
	public function get($name, array $arguments)
	{
		$class = 'MyApp\\Forms\\'.ucfirst($name);

		if (class_exists($class)) {
			return new $class();
		}
	}
}
```

Use it:

```php
use FormManager\Builder as F;

F::addFactory(new MyForms());

$editUser = F::editUserForm();
```

Note: Each time you register a new factory, it will be prepended to the already registered ones, so if you register fields/containers called "Form", "Textarea", etc, they will be used instead the default. This allows extend them.
