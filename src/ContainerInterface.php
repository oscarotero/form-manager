<?php

namespace FormManager;

/**
 * Interface used by all container elements.
 */
interface ContainerInterface extends ElementInterface
{
    /**
     * Set the key used to calculate the path of this node.
     *
     * @param mixed $key
     *
     * @return self
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
     * @return self
     */
    public function addValidator(callable $validator);

    /**
     * Removes a validator.
     *
     * @param callable $validator
     *
     * @return self
     */
    public function removeValidator($validator);

    /**
     * Register a sanitize for the value of this input.
     *
     * @param callable $sanitizer
     *
     * @return self
     */
    public function sanitize(callable $sanitizer);

    /**
     * Loads a value sent by the client.
     *
     * @param mixed $value The GET/POST/FILES values merged in an unique array
     *
     * @return self
     */
    public function load($value = null);

    /**
     * Set/Get the value.
     *
     * @param mixed $value null to getter, mixed to setter
     *
     * @return mixed
     */
    public function val($value = null);

    /**
     * Executes all validators and returns whether the value is valid or not.
     *
     * @return bool
     */
    public function validate();

    /**
     * Checks if the value is valid.
     *
     * @return bool
     */
    public function isValid();

    /**
     * Set/Get the current error message.
     *
     * @param null|string $error null to getter, string to setter
     *
     * @return mixed
     */
    public function error($error = null);
}
