<?php
namespace FormManager;

/**
 * Interface used by all elements that contains data.
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
     * Loads a value sent by the client.
     *
     * @param mixed $value The GET/POST value
     * @param mixed $file  The FILES value (used in input[type="file"])
     *
     * @return $this
     */
    public function load($value = null, $file = null);

    /**
     * Set/Get the value.
     *
     * @param mixed $value null to getter, mixed to setter
     *
     * @return mixed
     */
    public function val($value = null);

    /**
     * Checks if the value is valid.
     *
     * @return boolean
     */
    public function isValid();

    /**
     * Set/Get the error message.
     *
     * @param null|string $error null to getter, string to setter
     *
     * @return mixed
     */
    public function error($error = null);
}
