<?php
namespace FormManager\Elements;

use FormManager\InputInterface;

class InputWeek extends InputDatetime implements InputInterface
{
    protected $attributes = ['type' => 'week'];
    protected $format = 'Y-\WW';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Week::validate');
    }
}
