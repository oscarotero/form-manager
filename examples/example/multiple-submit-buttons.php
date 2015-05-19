<p>
    This example creates a form with two submit buttons. The given case is for
    when you might want to have a "Save" button and a "Save and Create Another" button
    for easily adding creating multiple records, for example.
</p>
<?php

use FormManager\Builder as F;

$form = F::form();

$save = F::submit();
$save->label('Save and View');

$saveAndCreate = F::submit();
$saveAndCreate->label('Save and create another');

$submitGroup = F::choose();
// The keys in the array here are the values of each element in the group
$submitGroup->add([
    'save' => $save,
    'saveAndCreate' => $saveAndCreate,
]);

// The key you give when you pass the group to the form becomes the name
$form->add(['submit' => $submitGroup]);

echo $form;
