<?php
namespace FormManager;

/**
 * Interface used by all inputs.
 */
interface InputInterface extends FormElementInterface
{
    /**
     * Set/Get/Generates an id for this element.
     *
     * @param null|string $id
     *
     * @return mixed
     */
    public function id($id = null);
}
