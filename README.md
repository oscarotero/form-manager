# FormManager

[![testing](https://github.com/oscarotero/form-manager/actions/workflows/main.yaml/badge.svg)](https://github.com/oscarotero/form-manager/actions/workflows/main.yaml)

> ### Note: this is the documentation of FormManager 6.x 
> For v5.x version [Click here](https://github.com/oscarotero/form-manager/tree/v5)

## Installation:

This package requires `PHP>=7.1` and is available on [Packagist](https://packagist.org/packages/form-manager/form-manager):

```
composer require form-manager/form-manager
```

## Create a field

FormManager is namespaced, but you only need to import a single class into your context:

```php
use FormManager\Factory as F;
```

Use the imported factory to create all form elements:

```php
//Create an input type="text" element
$name = F::text();

//Create the input with a label
$name = F::text('Please, introduce your name');

//Or with extra attributes
$name = F::text('Please, introduce your name', ['class' => 'name-field']);

//Add or remove attributes
$name->setAttribute('title', 'This is the name input');
$name->removeAttribute('class');
$name->setAttributes([
    'required',
    'readonly',
    'tabindex' => 2,
    'maxlength' => 50
]);

//Set the value
$name->setValue('MyName');

//Use magic properties to get/set/remove attributes
$name->class = 'name-field';
$name->required = false;
unset($name->readonly);
```

### List of all available inputs:

All HTML5 field types are supported:

* `F::checkbox($label, $attributes)`
* `F::color($label, $attributes)`
* `F::date($label, $attributes)`
* `F::datetimeLocal($label, $attributes)`
* `F::email($label, $attributes)`
* `F::file($label, $attributes)`
* `F::hidden($value, $attributes)`
* `F::month($label, $attributes)`
* `F::number($label, $attributes)`
* `F::password($label, $attributes)`
* `F::radio($label, $attributes)`
* `F::range($label, $attributes)`
* `F::search($label, $attributes)`
* `F::select($label, $options, $attributes)`
* `F::submit($label, $attributes)`
* `F::tel($label, $attributes)`
* `F::text($label, $attributes)`
* `F::textarea($label, $attributes)`
* `F::time($label, $attributes)`
* `F::url($label, $attributes)`
* `F::week($label, $attributes)`

> Note that all inputs accepts the same arguments except `hidden` and `select`.

## Validation

This library uses internally [symfony/validation](https://symfony.com/doc/current/validation.html) to perform basic html5 validations and error reporting. HTML5 validation attributes like `required`, `maxlength`, `minlength`, `pattern`, etc are supported, in addition to intrinsic validations assigned to each input like email, url, date, etc.

```php
$email = F::email();

$email->setValue('invalid-email');

//Validate the value
if ($email->isValid()) {
    return true;
}

//Get errors
$error = $email->getError();

//Print the first error message
echo $error;

//Iterate through all messages
foreach ($error as $err) {
    echo $err->getMessage();
}

//You can also customize/translate the error messages
$email->setErrorMessages([
    'email' => 'The email is not valid',
    'required' => 'The email is required',
    'maxlength' => 'The email is too long, it must have {{ limit }} characters or less',
]);

//And add more symfony validators
$ip = F::text();
$ip->addConstraint(new Constraints\Ip());
```

See [all constraints supported by symfony](https://symfony.com/doc/current/validation.html#supported-constraints)


## Render html

```php
$name = F::text('What is your name?', ['name' => 'name']);

echo $name;
```
```html
<label for="id-input-1">What is your name?</label> <input id="id-input-1" type="text" name="name">
```

Set a custom template using `{{ label }}` and `{{ input }}` placeholders:

```php
$name->setTemplate('{{ label }} <div class="input-content">{{ input }}</div>');
echo $name;
```
```html
<label for="id-input-1">What is your name?</label> <div class="input-content"><input id="id-input-1" type="text" name="name"></div>
```

If you want to wrap the previous template in a custom html, use the `{{ template }}` placeholder:

```php
$name->setTemplate('<fieldset>{{ template }}</fieldset>');
echo $name;
```
```html
<fieldset><label for="id-input-1">What is your name?</label> <div class="input-content"><input id="id-input-1" type="text" name="name"></div></fieldset>
```

## Grouping fields

Group the fields to follow a specific data structure:

### Group

Groups allow to place a set of inputs under an specific name:

```php
$group = F::group([
    'name' => F::text('Username'),
    'email' => F::email('Email'),
    'password' => F::password('Password'),
]);

$group->setValue([
    'name' => 'oscar',
    'email' => 'oom@oscarotero.com',
    'password' => 'supersecret',
]);
```

### Radio group

Special case for radios where all inputs share the same name with different values:

```php
$radios = F::radioGroup([
    'red' => 'Red',
    'blue' => 'Blue',
    'green' => 'Green',
]);

$radios->setValue('blue');
```

### Submit group

Special case to group several submit buttons under the same name but different values:

```php
$buttons = F::submitGroup([
    'save' => 'Save the row',
    'duplicate' => 'Save as new row',
]);

$buttons->setName('action');
```

### Group collection

Is a collection of values using the same group:

```php
$groupCollection = F::groupCollection(
    f::group([
        'name' => F::text('Name'),
        'genre' => F::radioGroup([
            'm' => 'Male',
            'f' => 'Female',
            'o' => 'Other',
        ]),
    ])
]);

$groupCollection->setValue([
    [
        'name' => 'Oscar',
        'genre' => 'm'
    ],[
        'name' => 'Laura',
        'genre' => 'f'
    ],
])
```

### Multiple group collection

Is a collection of values using various groups, using the field `type` to identify which group is used by each row:

```php
$multipleGroupCollection = F::multipleGroupCollection(
    'text' => f::group([
        'type' => F::hidden(),
        'title' => F::text('Title'),
        'text' => F::textarea('Body'),
    ]),
    'image' => f::group([
        'type' => F::hidden(),
        'file' => F::file('Image file'),
        'alt' => F::text('Alt text'),
        'text' => F::textarea('Caption'),
    ]),
    'link' => f::group([
        'type' => F::hidden(),
        'text' => F::text('Link text'),
        'href' => F::url('Url'),
        'target' => F::select([
            '_blank' => 'New window',
            '_self' => 'The same window',
        ]),
    ]),
]);

$multipleGroupCollection->setValue([
    [
        'type' => 'text',
        'title' => 'Welcome to my page',
        'text' => 'I hope you like it',
    ],[
        'type' => 'image',
        'file' => 'avatar.jpg',
        'alt' => 'Image of mine',
        'text' => 'This is my photo',
    ],[
        'type' => 'link',
        'text' => 'Go to my webpage',
        'href' => 'https://oscarotero.com',
        'target' => '_self',
    ],
]);
```

## Datalist

[Datalist](http://www.w3.org/TR/html5/forms.html#the-datalist-element) are also allowed, just use the `createDatalist()` method:

```php
$input = F::search();

$datalist = $input->createDatalist([
    'female' => 'Female',
    'male' => 'Male'
]);

echo $input;
echo $datalist;
```

## Forms

We need a form to put all this things together.

```php
$loginForm = F::form([
    'username' => F::text('User name'),
    'password' => F::password('Password'),
    '' => F::submit('Login'),
]);

$loginForm->setAttributes([
    'action' => 'login.php',
    'method' => 'post',
]);

//Load data from globals $_GET, $_POST, $_FILES
$loginForm->loadFromGlobals();

//Load data passing the arrays
$loginForm->loadFromArrays($_GET, $_POST, $_FILES);

//Or load from PSR-7 server request
$loginForm->loadFromServerRequest($serverRequest);

//Get loaded data
$data = $loginForm->getValue();

//Print the form
echo $loginForm;

//Access to specific inputs:
echo $loginForm->getOpeningTag();
echo '<h2>Login:</h2>';

echo $loginForm['username'];
echo '<hr>';
echo $loginForm['password'];
echo '<hr>';
echo $loginForm[''];
echo $loginForm->getClosingTag();

//Iterate with all inputs
echo $loginForm->getOpeningTag();
echo '<h2>Login:</h2>';

foreach ($loginForm as $input) {
    echo "<div>{$input}</div>";
}
echo $loginForm->getClosingTag();
```
