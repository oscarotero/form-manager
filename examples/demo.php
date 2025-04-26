<?php

require __DIR__.'/../vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use FormManager\Factory as F;
use FormManager\Inputs\Input;

$form = F::form([
    'accept' => F::checkbox('I am a human'),
    'color' => F::color('My favorite color'),
    'birthday' => F::date('My birthday'),
    'now' => F::datetimeLocal('Current time'),
    'email' => F::email('My email'),
    'file' => F::file('Avatar', ['accept' => '.png']),
    'id' => F::hidden(23),
    'holidays' => F::month('Best holiday month'),
    'siblings' => F::number('Sisters and brothers'),
    'password' => F::password('Your password'),
    'genre' => F::radioGroup([
        'm' => 'Male',
        'f' => 'Female',
        'o' => 'Other',
    ]),
    'size' => F::range('How tall are you?'),
    'search' => F::search('Search'),
    'phone' => F::tel('Telephone number'),
    'name' => F::text('Name'),
    'address' => F::group([
        'line1' => F::textarea('Address line 1'),
        'line2' => F::textarea('Address line 2'),
    ]),
    'dinner' => F::time('Dinner hour'),
    'site' => F::url('Your web page'),
    'week' => F::week('The best week of your life'),
    'language' => F::select('Favorite programing language')
        ->setOptions([
            'php' => 'PHP',
            'js' => 'Javascript',
            'python' => 'Python',
        ]),
    'images' => F::groupCollection(
        F::group([
            'file' => F::file('Image file'),
            'caption' => F::text('Caption'),
        ])
    )->setValue([[]]),
    'bio' => F::multipleGroupCollection([
        'text' => F::group([
            'type' => F::hidden('text'),
            'title' => F::text('Title'),
            'text' => F::textarea('Body'),
        ]),
        'image' => F::group([
            'type' => F::hidden('image'),
            'file' => F::file('Image'),
            'caption' => F::text('Caption'),
        ]),
        'button' => F::group([
            'type' => F::hidden('image'),
            'text' => F::text('Text'),
            'url' => F::url('Url'),
        ]),
    ])->setValue([['type' => 'text']]),
    'action' => F::submitGroup([
        'save' => 'Save',
        'duplicate' => 'Duplicate',
    ]),
]);


$form->method = 'POST';

if ($_POST) {
    $form->loadFromGlobals();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Demo</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 2em;
        }
        pre {
            background: #eee;
            color: #999;
            padding: 1em;
            overflow: auto;
        }
    </style>
</head>
<body>
    <?= $form->getOpeningTag(); ?>
    <?php foreach ($form as $field): ?>
    <div>
        <?= $field; ?>
        <?php
        if ($field instanceof Input) {
            $field->getError();
        }
        ?>
        <pre><?= htmlspecialchars((string) $field); ?></pre>
    </div>
    <?php endforeach; ?>
    <?= $form->getClosingTag(); ?>

    <pre><?php print_r($form->getValue()); ?></pre>
</body>
</html>
