<?php

require __DIR__.'/vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use FormManager\Factory as f;
use FormManager\Input;

$form = f::form([
    'accept' => f::checkbox('I am a human'),
    'color' => f::color('My favorite color'),
    'birthday' => f::date('My birthday'),
    'now' => f::datetimeLocal('Current time'),
    'email' => f::email('My email'),
    'file' => f::file('Avatar', ['accept' => '.png']),
    'id' => f::hidden(23),
    'holidays' => f::month('Best holiday month'),
    'siblings' => f::number('Sisters and brothers'),
    'password' => f::password('Your password'),
    'genre' => f::radioGroup([
        'm' => 'Male',
        'f' => 'Female',
        'o' => 'Other',
    ]),
    'size' => f::range('How tall are you?'),
    'search' => f::search('Search'),
    'phone' => f::tel('Telephone number'),
    'name' => f::text('Name'),
    'address' => f::group([
        'line1' => f::textarea('Address line 1'),
        'line2' => f::textarea('Address line 2'),
    ]),
    'dinner' => f::time('Dinner hour'),
    'site' => f::url('Your web page'),
    'week' => f::week('The best week of your life'),
    'language' => f::select([
        'php' => 'PHP',
        'js' => 'Javascript',
        'python' => 'Python',
    ], 'Favorite programing language'),
    'images' => f::groupCollection(
        f::group([
            'file' => f::file('Image file'),
            'caption' => f::text('Caption'),
        ])
    )->setValue([[]]),
    'bio' => f::multipleGroupCollection([
        'text' => f::group([
            'type' => f::hidden('text'),
            'title' => f::text('Title'),
            'text' => f::textarea('Body'),
        ]),
        'image' => f::group([
            'type' => f::hidden('image'),
            'file' => f::file('Image'),
            'caption' => f::text('Caption'),
        ]),
        'button' => f::group([
            'type' => f::hidden('image'),
            'text' => f::text('Text'),
            'url' => f::url('Url'),
        ]),
    ])->setValue([['type' => 'text']]),
    '' => f::submit('Send')
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
    <?= $form->getOpeningTag() ?>
    <?php foreach ($form as $field): ?>
    <div>
        <?= $field ?>
        <?php
        if ($field instanceof Input) {
            $field->getError();
        }
        ?>
        <pre><?= htmlspecialchars((string) $field) ?></pre>
    </div>
    <?php endforeach ?>
    <?= $form->getClosingTag() ?>
</body>
</html>
