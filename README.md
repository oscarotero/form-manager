FormManager
===========

Created by Oscar Otero <http://oscarotero.com> <oom@oscarotero.com>

GNU Affero GPL version 3. http://www.gnu.org/licenses/agpl-3.0.html

Requirements:

* PHP 5.3
* Any PSR-0 autoloader


Create a input
--------------

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

//Print the html input (with the label)
echo $name;

//Print the html input with some extra attributes:
echo $name->toHtml(array('class' => 'text-input'));
```

Create a form
-------------

```php
use FormManager\Form;
use FormManager\Input;

class MyForm extends Form {
	public function __construct () {
		$this->attr('action', 'test.php');

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

//You can also add new inputs using the array syntax (the key will be the input name):
$MyForm = new MyForm();

$MyForm['new-input'] = Input::range()->min(0)->max(100);

//Print the form
echo $MyForm;

//Print the form in diferent pieces
echo $MyForm->openHtml(); //<form action="test.php" method="get">

foreach ($MyForm as $Input) {
	echo $Input;
}
echo '</form>';

//Access to the inputs using key names
echo $MyForm->openHtml();

echo $MyForm['email']->toHtml(array('class' => 'email-input'));
...

echo '</form>';
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