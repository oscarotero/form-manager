<?php
/**
 * Trait with common method for validation
 */
namespace FormManager\Traits;

trait ValidationTrait
{
    protected $validators = [];
    protected $error;

    /**
     * Adds new value validator
     *
     * @param string   $name      The validator name
     * @param callable $validator The validator function
     *
     * @return self
     */
    public function addValidator($name, $validator)
    {
        $this->validators[$name] = $validator;

        return $this;
    }

    /**
     * Removes a validator
     *
     * @param string $name The validator name
     *
     * @return self
     */
    public function removeValidator($name)
    {
        unset($this->validators[$name]);

        return $this;
    }

    /**
     * Executes all validators and returns whether the value is valid or not
     *
     * @return boolean
     */
    public function validate()
    {
        $this->error = null;

        foreach ($this->validators as $validator) {
            if (($error = $validator($this)) !== true) {
                $this->error($error);

                return false;
            }
        }

        return true;
    }

    /**
     * Set/Get the error message
     *
     * @param null|string $error null to getter, string to setter
     *
     * @return null|string
     */
    public function error($error = null)
    {
        if ($error === null) {
            return $this->error;
        }

        $this->error = $error;

        return $this;
    }
}
