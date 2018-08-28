<?php
declare(strict_types = 1);

namespace FormManager;

/**
 * Interface representing an input element
 */
interface InputInterface extends NodeInterface
{
    public function setName(string $name): InputInterface;

    public function setValue($value): InputInterface;

    public function getValue();
}
