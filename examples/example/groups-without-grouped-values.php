<p>
    This example creates a form with three groups of elements, however only the last
    one causes the child field names to be places into an array for submission.
</p>
<?php

use FormManager\Builder as F;

$form = F::form();

$groupOne = F::group();
$groupOne->add([
    'valueOne'=> F::text(),
]);

$groupTwo = F::group();
$groupTwo->add([
    'valueTwo'=> F::text(),
]);

$groupThree = F::group();
$groupThree->add([
    'valueThree'=> F::text(),
]);

$groupFour = F::group();
$groupFour->add([
    'valueFour'=> F::text(),
]);

// The key becomes the array name, but if the key name is numeric then it
// will not be used.
$form->add([
    $groupOne,
    $groupTwo,
    'arrayify-me' => $groupThree,
    // Note that this also counts as an integer, but it would be nice if it did not
    '4' => $groupFour,
]);

echo $form;
