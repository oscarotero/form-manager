This is a fork of [form-manager] (https://github.com/oscarotero/form-manager)

Create a form
-------------

```php
use FormManager\Form;
use FormManager\Input;

class MyForm extends Form {
    public function __construct () {
        $this->attr('action', 'test.php');

        $this->inputs(array(
            'title' => Select::Text()->required()->label('Title')->options(array(1 => 'Mr.', 2 => 'Mrs.', 3 => 'Family')),
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
```