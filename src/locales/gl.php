<?php
use FormManager\Validators;

Validators\Accept::$error_message = 'O tipo de arquivo neste campo debe ser %s';
Validators\Color::$error_message = 'Este valor non corresponde a unha cor válida';
Validators\Date::$error_message = 'Este valor non é unha data válida';
Validators\Datetime::$error_message = 'Este valor non é unha data e hora válida';
Validators\DatetimeLocal::$error_message = 'Este valor non é unha data e hora local válida';
Validators\Email::$error_message = 'Este valor non é un correo electrónico válido';
Validators\File::$error_message = [
    1 => 'O arquivo subido supera o máximo permitido pola directiva upload_max_filesize de php.ini',
    2 => 'O arquivo subido supera o máximo permitido pola directiva MAX_FILE_SIZE especificada no formulario HTML',
    3 => 'O arquivo foi parcialmente subido',
    6 => 'Non se atopou o directorio temporal',
];
Validators\Max::$error_message = 'O valor máximo permitido é %s';
Validators\Maxlength::$error_message = 'A lonxitude máxima permitida é %s';
Validators\Min::$error_message = 'O valor mínimo permitido é %s';
Validators\Month::$error_message = 'Este valor non corresponde a un mes válido';
Validators\Number::$error_message = 'Este valor non corresponde a un número válido';
Validators\Pattern::$error_message = 'Este valor non é válido';
Validators\Required::$error_message = 'Este valor é obligatorio';
Validators\Select::$error_message = 'Este valor non é válido';
Validators\Time::$error_message = 'Este valor non é unha hora válida';
Validators\Url::$error_message = 'Este valor non é unha dirección web válida';
Validators\Week::$error_message = 'Este valor non corresponde a unha semana válida';
