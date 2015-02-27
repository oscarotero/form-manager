<?php
namespace FormManager;

/**
 * Interface used by all elements that contains data
 */
interface DataElementInterface extends ElementInterface
{
    /**
     * Set the key used to calculate the path of this node.
     *
     * @param mixed $key
     *
     * @return $this
     */
    public function setKey($key);

    /**
     * Get the full path of this node
     * Used to calculate the real name of each input.
     *
     * @return null|string
     */
    public function getPath();

    /**
     * push a new validator.
     *
     * @param callable $validator
     *
     * @return $this
     */
    public function addValidator(callable $validator);

    /**
     * Removes a validator.
     *
     * @param callable $validator
     *
     * @return $this
     */
    public function removeValidator($validator);

    /**
     * Register a sanitize for the value of this input.
     *
     * @param callable $sanitizer
     *
     * @return $this
     */
    public function sanitize(callable $sanitizer);

    /**
     * Register a custom render function for this input.
     *
     * @param callable $render
     *
     * @return $this
     */
    public function render(callable $render);
}
