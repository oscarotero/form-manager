<?php
/**
 * Trait with methods to save arbitrary variables
 */
namespace FormManager\Traits;

trait VarsTrait
{
    protected $vars = [];


    /**
     * Set variables
     *
     * @param null|string|array $name  If it's null, returns an array with all variables
     * @param null|string|array $value null to getter, string to setter
     *
     * @return mixed
     */
    public function set($name, $value)
    {
        if (is_array($name)) {
            $this->vars += $name;

            return $this;
        }

        $this->vars[$name] = $value;

        return $this;
    }

    /**
     * Get variables
     *
     * @param null|string $name  If it's null, returns an array with all variables
     *
     * @return mixed
     */
    public function get($name = null)
    {
        if ($name === null) {
            return $this->vars;
        }

        return isset($this->vars[$name]) ? $this->vars[$name] : null;
    }
}
