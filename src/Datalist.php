<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Traits\HasOptionsTrait;

/**
 * Class representing a datalist element
 */
class Datalist extends Node
{
    use HasOptionsTrait;

    public function __construct(iterable $options, iterable $attributes = [])
    {
        parent::__construct('datalist', $attributes);

        $this->setOptions($options);
    }
}
