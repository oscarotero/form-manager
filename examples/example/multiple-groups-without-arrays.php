<p>
    Usually if you use a group then all fields within that group will be put into
    HTML field arrays (e.g &lt;input name=group1[field1]&gt; ) which is often not the
    desired outcome. You can get past this by having falsy group names.
</p>
<?php

use FormManager\Bootstrap as FB;

$form = FB::form();

$field1 = FB::text()->label('Field 1');
$field2 = FB::text()->label('Field 2');

// The Group will act as the 'row'
$group1 = FB::group();
$group2 = FB::group();

// The keys in the array here are the names of each element
$group1->add([
    'field1' => $field1,
]);
$group2->add([
    'field2' => $field2,
]);

// If you give the group a key then all the fields will have their values grouped by that.
// If the key is falsy then they won't (e.g 0, or '')
$form->add([
    0 => $group1,
    '' => $group2,
]);

echo $form;
