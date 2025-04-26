<?php

require __DIR__.'/../vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use FormManager\Factory as F;
use Symfony\Component\Translation\Loader\JsonFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;

// $ composer require symfony/translations

$locale = 'es';
$translator = new Translator($locale);
$translator->addLoader('json', new JsonFileLoader());
$translator->addResource('json', __DIR__.'/translations.json', $locale, 'validators');

// Create validator with translator
$validator = Validation::createValidatorBuilder()
    ->setTranslator($translator)
    ->setTranslationDomain('validators')
    ->getValidator();

// Set validator
F::setValidator($validator);

// Create the email field
$email = F::email('Email');
$email->setValue('invalid-email');

// Get and display errors
$error = $email->getError();

foreach ($error as $err) {
    echo "Error message: " . $err->getMessage() . "\n";
}
