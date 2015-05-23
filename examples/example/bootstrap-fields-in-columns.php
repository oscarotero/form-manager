<p>
    This example creates a form with a collection of fields and puts them
    into two (or more) columns.
</p>
---
<?php

use FormManager\Bootstrap as FB;

$form = FB::form();

$field1 = FB::text()->label('Field 1');
$field2 = FB::text()->label('Field 2');
$field3 = FB::text()->label('Field 3');

$field4 = FB::text()->label('Field 4');
$field5 = FB::text()->label('Field 5');
$field6 = FB::text()->label('Field 6');

// The Group will act as the 'row'
$group = FB::group();

// The keys in the array here are the names of each element
$group->add([
    'field1' => $field1,
    'field2' => $field2,
    'field3' => $field3,
    'field4' => $field4,
    'field5' => $field5,
    'field6' => $field6,
]);

// You the need to set the width on each field accordingly. You can add
// more than one class if you wish (e.g "col-sm-6 col-lg-4" )
$group->set([
    'columnSizing' => [
        'field1' => 'col-sm-6',
        'field2' => 'col-sm-6',
        'field3' => 'col-sm-6',
        'field4' => 'col-sm-6',
        'field5' => 'col-sm-6',
        'field6' => 'col-sm-6',
    ],
]);

// If you give the group a key then all the fields will have their values grouped by that.
// If the key is falsy then they won't (e.g 0, null or '')
$form->add([$group]);

echo $form;
