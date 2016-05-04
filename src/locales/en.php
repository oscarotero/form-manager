<?php

use FormManager\Validators;

Validators\Accept::$error_message = 'The mime type of this input must be %s';
Validators\Color::$error_message = 'This value is not a valid color';
Validators\Datetime::$error_message = [
    'date' => 'This value is not a valid date',
    'datetime' => 'This value is not a valid datetime',
    'datetimelocal' => 'This value is not a valid local datetime',
    'month' => 'This value is not a valid month',
    'time' => 'This value is not a valid time',
    'week' => 'This value is not a valid week',
];
Validators\Email::$error_message = 'This value is not a valid email';
Validators\File::$error_message = [
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    6 => 'Missing a temporary folder',
];
Validators\Max::$error_message = 'The max value allowed is %s';
Validators\Maxlength::$error_message = 'The max length allowed is %s';
Validators\Min::$error_message = 'The min value allowed is %s';
Validators\Number::$error_message = 'This value is not a valid number';
Validators\Pattern::$error_message = 'This value is not valid';
Validators\Required::$error_message = 'This value is required';
Validators\Select::$error_message = 'This value is not valid';
Validators\Url::$error_message = 'This value is not a valid url';
