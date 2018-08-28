<?php

require __DIR__.'/vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use FormManager\Factory as f;

$inputs = [
    'Checkbox',
    'Color',
    'Date',
    'DatetimeLocal',
    'Email',
    'File',
    'Hidden',
    'Month',
    'Number',
    'Password',
    'Radio',
    'Range',
    'Search',
    'Tel',
    'Text',
    'Textarea',
    'Time',
    'Url',
    'Week',
];

$form = f::form();

foreach ($inputs as $input) {
    $form[$input] = f::$input()->setLabel($input)->setFormat('<div>{format}</div>');
}

$form['select'] = f::select([
    '' => 'None',
    1 => 'One',
    2 => 'Two',
], 'Select an option');

$form['color'] = f::radioGroup([
    'red' => 'Vermello',
    'blue' => 'Azul',
]);

$form['user'] = f::group([
    'name' => f::text('nome'),
    'age' => f::number('idade'),
    'direction' => f::group([
        'line1' => f::text('Line 1'),
        'line2' => f::text('Line 2'),
        'type' => f::radioGroup([
            'rua' => 'Rúa',
            'avenida' => 'Avenida',
        ])
    ])
]);

$form['images'] = f::groupCollection(
    f::group([
        'file' => f::file('Image file'),
        'caption' => f::text('Caption'),
    ])
)->setValue([
        [
            'file' => 'foo',
            'caption' => 'bar',
        ],[
            'file' => 'foo',
            'caption' => 'bar2',
        ],
    ]);

$form['body'] = f::multipleGroupCollection([
    'text' => f::group([
        'text' => f::textarea('Texto')
    ]),
    'image' => f::group([
        'image' => f::file('Arquivo')
    ]),
    'age' => f::group([
        'years' => f::range('Anos')
    ]),
])->setValue([
    [
        'type' => 'text',
        'text' => 'Ola'
    ],[
        'type' => 'text',
        'text' => 'Ola 2'
    ],[
        'type' => 'age',
        'years' => 50
    ]
]);

$form[''] = f::submit('Send');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Demo</title>
</head>
<body>
    <?= $form ?>
</body>
</html>
