<?php

use FormManager\Validators;

Validators\Accept::$error_message = 'The mime type of this input must be %s';
Validators\Color::$error_message = 'This value is not a valid color';
Validators\Date::$error_message = 'This value is not a valid date';
Validators\Datetime::$error_message = 'This value is not a valid datetime';
Validators\DatetimeLocal::$error_message = 'This value is not a valid local datetime';
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
Validators\Month::$error_message = 'This value is not a valid month';
Validators\Number::$error_message = 'This value is not a valid number';
Validators\Pattern::$error_message = 'This value is not valid';
Validators\Required::$error_message = 'This value is required';
Validators\Select::$error_message = 'This value is not valid';
Validators\Time::$error_message = 'This value is not a valid time';
Validators\Url::$error_message = 'This value is not a valid url';
Validators\Week::$error_message = 'This value is not a valid week';
