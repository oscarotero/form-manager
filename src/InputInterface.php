<?php
declare(strict_types = 1);

namespace FormManager;

/**
 * Interface representing an input element
 *
 * @template TInput of NodeInterface
 */
interface InputInterface extends NodeInterface
{
    /**
     * @return TInput
     */
    public function setName(string $name);

    /**
     * @return TInput
     */
    public function setValue($value);

    public function getValue();

    public function isValid(): bool;
}
