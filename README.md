# FormManager

[![Build Status](https://travis-ci.org/oscarotero/form-manager.png?branch=master)](https://travis-ci.org/oscarotero/form-manager)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oscarotero/form-manager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oscarotero/form-manager/?branch=master)

Created by Oscar Otero <http://oscarotero.com> <oom@oscarotero.com>

Requirements:

* PHP 5.4

Installation:

Create or edit your composer.json file:

```json
{
	"require": {
		"form-manager/form-manager": "*"
	}
}
```

## Create an input

### Using the jquery syntax:

```php
use FormManager\Builder;

//Create an input type="text" element

$name = Builder::text();

//Use the jQuery syntax to set, get or remove attributes:

$name->attr('name', 'username');

$name->attr(array(
	'maxlength' => 50,
	'required' => true
));

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
```

### The magic methods

```php
$name = Builder::text();

$name->required(); //its like $name->attr('required', true);
$name->required(false); //its like $name->attr('required', false);

//You can chain methods:
$name->pattern('[a-z]+')->required()->maxlength(100);
```

### Generate the html code

The html code is created automatically on convert the object to a string:

```php
$name = Builder::text()->class('my-input');

echo $name; //<input type="text" class="my-input">

//print the input with extra attributes
echo $name->addClass('text-input')->placeholder('Your name');

//You can customize the render function:
$name->render(function ($input) {
	return '<div class="field">'.$field.'</div>';
});
```

### Working with data

The input can load, sanitize and validate the data:

```php
$url = Builder::url();

$url->val('invalid-url');

if (!$url->isValid()) {
	echo $url->error();
}

//Add a function to sanitize the data:
$name = Builder::text();

$name->sanitize(function ($value) {
	return strip_tags($value);
});

//Use load() to get the raw data
$name->load('my name is <strong>earl</strong>');
echo $name->val(); //my name is earl

//Add custom validators
$name->addValidator('is-dave', function ($input) {
	return ($input->val() === 'dave') ?: 'This value must be "dave"';
});

//Or remove them
$name->removeValidator('is-dave');
```

### Labels

You can use a label with your input, just use the property `->label`. It may also generate an extra label with the error message.

```php
$name = Builder::text();

//Define a label
$name->label('User name');

//And modify the label using the same syntax:
$name->label->class('main-label');

//Print all (label + input)
echo $name;
```

## Containers

A container is an object that contain inputs or other containers. There are various types of containers, deppending of the data structure:

### Group

A group is a simple container to store inputs/containers by name. For example, here a group of three inputs to store a date:

```php
$date = Builder::group([
	'day' => Builder::number()->min(1)->max(31)->label('Day'),
	'month' => Builder::number()->min(1)->max(12)->label('Month'),
	'year' => Builder::number()->min(1900)->max(2013)->label('Year')
]);

//Set the value
$date->val([
	'day' => 21,
	'month' => 6,
	'year' => 1979
]);

//Use arrayAccess to get the inputs by name
$year = $date['year']->val();

//Add more fields dinamically
$date['hour'] = Builder::number()->min(0)->max(23)->label('Hour');

//Get values
$values = $date->val();

echo $values['year'];
```

### Choose

This container stores inputs with the same name but different values. Useful for radio inputs or to define various submit buttons.

```php
//Create a choose container
$colors = Builder::choose();

//Add some fields. The keys will be the values
$colors->add([
	'red' => Builder::radio()->label('Red'),
	'blue' => Builder::radio()->label('Blue'),
	'green' => Builder::radio()->label('Green')
]);

//Access to the fields by value
$radio = $colors['red'];

//Add more fields dinamically
$colors['yellow'] = Builder::radio()->label('Yellow');

//Set the value
$colors->val('red');

//Get values
$color_choosen = $colors->val();
```

### Collection

It's like a [group](#group), but stores a collection of values:

```php
//Create a collection field
$people = Builder::collection([
	'name' => Builder::text()->label('Name'),
	'email' => Builder::email()->label('email'),
	'age' => Builder::number()->label('Age')
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

//Get fieldsets by number
echo $people[0]['name']->val(); //returns 'Xaquín'

//Push a new value
$people->pushVal([
	'name' => 'Manoela',
	'email' => 'manoela@email.com',
	'age' => '18'
]);

//Returns the group container used as template for each value.
$template = $people->getTemplate();

//useful to create the template in javascript
echo '<div class="template">' + $template + '</div>';
```

### CollectionMultiple

If you need different types of values in your collection, CollectionMultiple is your container:

```php
//Create a collectionMultiple
$article = Builder::collectionMultiple([
	'section' => [
        'title' => Builder::text()->label('Title'),
        'text' => Builder::textarea()->label('Text')
    ],
    'picture' => [
        'caption' => Builder::text()->label('Caption'),
        'image' => Builder::file()->label('Image')
    ],
    'quote' => [
        'text' => Builder::textarea()->label('Text'),
        'author' => Builder::text()->label('Author')
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

// ArrayAccess
echo $article[0]['title']->val(); //returns 'This is the section title'
$article[1]['author']->val('Anonimous');

// Add new values
$article->pushVal([
	'type' => 'section',
	'title' => 'This is another section',
    'text' => 'The world of dogs are better than the cats because...',
]);

//Add new types
$article->add([
	'video' => [
		'title' => Field::text()->label('Title'),
		'video' => Field::url()->label('Youtube url')
	]
]);

//Returns an array with all templates used
$templates = $article->getTemplate();

foreach ($templates as $name => $template) {
	echo '<div class="template-'.$name.'">' + $template + '</div>';
}
```

## Forms

Ok, we need a form to put all together. The form is just another container, in fact, it's like a [Group](#group).

```php
$form = Builder::form();

//Set the form attributes:
$form->action('test.php')->method('post');

$form->addClass('my-form');

//Add some inputs and containers

$form->add([
	'name' => Builder::text()->maxlength(50)->required()->label('Your name'),
	'email' => Builder::email()->label('Your email'),
	'telephone' => Builder::tel()->label('Telephone number'),

	'gender' => Builder::choose([
		'm' => Builder::radio()->label('Male'),
		'f' => Builder::radio()->label('Female')
	]),
	
	'born' => Builder::group([
		'day' => Builder::number()->min(1)->max(31)->label('Day'),
		'month' => Builder::number()->min(1)->max(12)->label('Month'),
		'year' => Builder::number()->min(1900)->max(2013)->label('Year')
	]),

	'language' => Builder::select()->options(array(
		'gl' => 'Galician',
		'es' => 'Spanish',
		'en' => 'English'
	))->label('Language'),

	'friends' => Builder::collection([
		'name' => Builder::text()->label('Name'),
		'email' => Builder::email()->label('email'),
		'age' => Builder::number()->label('Age')
	]),

	'action' => Builder::choose([
		'save' => Builder::submit()->html('Save changes'),
		'duplicate' => Builder::submit()->html('Save changes')
	])
]);

//You can also add new inputs using the array syntax (the key will be the input name):
$MyForm['new-input'] = Builder::range()->min(0)->max(100)->val(50);

//Print the form
echo $MyForm;

//Access to the fields using key names
echo $MyForm['website'];

//Or fields inside fields
echo $MyForm['born']['day'];

//Set/get the values to all inputs:
$MyForm->val([
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

$values = $MyForm->val();

//To load the values from globals $_GET, $_POST and $_FILES:
$MyForm->loadFromGlobals();

//Or specify your fake globals
$MyForm->loadFromGlobals($_fake_GET, $_fake_POST, $_fake_FILES);

//Or values manually (like any input):
if ($MyForm->attr('method') === 'post') {
	$MyForm->load($_POST);
} else {
	$MyForm->load($_GET);
}

//Check the errors
if (!$MyForm->isValid()) {
	echo 'there are errors in the form';
}
```

## Builder

Ok, you've seen the class `Builder` in all examples above. This class eases the creation of inputs and containers. For example, instead of do this:

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
use FormManager\Builder;

$form = Builder::form([
	'name' => Builder::text(),
	'bio' => Builder::textarea()
]);
```

The `FormManager\Builder` handles the instantation of all theses classes for you using factories. By default, it contains the `FormManager\Factory` factory, responsible of instantation of all inputs and containers.

But you can add your owns factories, creating classes implementing `FormManager\FactoryInterface`.

This is useful for a lot of things. Imagine a class that creates custom inputs for you:

```php
use FormManager\Builder;
use FormManager\FactoryInterface;

class CustomInputs implements FactoryInterface
{
	/**
	 * Method required in the interface
	 */
	public function get($name, array $arguments)
	{
		if (method_exists($this, $name)) {
			return $this->$name();
		}
	}

	public function selectWeek()
	{
		return Builder::select()->options([
			'monday',
			'tuesday',
			'wednesday',
			'thursday',
			'friday',
			'saturday',
			'sunday'
		]);
	}
}
```

Now in your app:

```php
use FormManager\Builder;

Builder::addFactory(new CustomInputs());

$form = Builder::form([
	'week' => Builder::selectWeek()
]);
```

Other usage example is save all forms of your app under a namespace:

```php
namespace MyApp\Forms;

use FormManager\Builder;
use FormManager\Containers\Form;

class EditUserForm extends Form
{
	public function __construct()
	{

		$this->add([
			'name' => Builder::text()->maxlength(200)->label('Name'),
			'email' => Builder::email()->label('Email'),
			'password' => Builder::password()->label('Password'),
			'repeat_password' => Builder::password()->label('Repeat password'),
		]);

		//Add a validator to check the password
		$this->addValidator('password-check', function ($form) {
			$password1 = $form['password']->val();
			$password2 = $form['repeat_password']->val();

			if ($password1 != $password2) {
				return 'The passwords does not match';
			}

			return true;
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
		$class = 'MyApp\\Forms\\'.ucfirs($name);

		if (class_exists($class)) {
			return new $class();
		}
	}
}
```

Now use it:

```php
use FormManager\Builder;

Builder::addFactory(new MyForms());

$editUser = Builder::editUserForm();
```

Note: Each time you register a new factory, it will be prepended to the already registered ones, so if you register inputs/containers called "Form", "Textarea", etc, they will be used instead the default. This allows customize the default behaviours.
