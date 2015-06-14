<?php
require __DIR__.'/vendor/autoload.php';

use FormManager\Builder as F;
use Zend\Diactoros\ServerRequestFactory;

$form = F::Form([
    'picture' => F::file()
        ->accept('image/jpeg')
        ->label('Upload'),
    'submit' => F::submit()->html('Send'),
])
->method('post')
->enctype('multipart/form-data');


$form->loadFromPsr7ServerRequest(ServerRequestFactory::fromGlobals());

if (!$form->isValid()) {
    echo 'Invalid values';
}

echo $form;
