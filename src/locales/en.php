<?php
use FormManager\Inputs;
use FormManager\Attributes;

Inputs\Color::$error_message = 'This value is not a valid color';
Inputs\Date::$error_message = 'This value is not a valid date';
Inputs\Datetime::$error_message = 'This value is not a valid datetime';
Inputs\DatetimeLocal::$error_message = 'This value is not a valid local datetime';
Inputs\Email::$error_message = 'This value is not a valid email';
Inputs\Month::$error_message = 'This value is not a valid month';
Inputs\Number::$error_message = 'This value is not a valid number';
Inputs\Select::$error_message = 'This value is not valid';
Inputs\Time::$error_message = 'This value is not a valid time';
Inputs\Url::$error_message = 'This value is not a valid url';
Inputs\Week::$error_message = 'This value is not a valid week';

Attributes\Accept::$error_message = 'The mime type of this input must be %s';
Attributes\Max::$error_message = 'The max value allowed is %s';
Attributes\Maxlength::$error_message = 'The max length allowed is %s';
Attributes\Min::$error_message = 'The min value allowed is %s';
Attributes\Pattern::$error_message = 'This value is not valid';
Attributes\Required::$error_message = 'This value is required';
