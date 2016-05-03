<?php

namespace FormManager\Traits;

/**
 * Trait with common methods to build the data structure.
 */
trait StructureTrait
{
    protected $key;

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function getPath()
    {
        if (!($parent = $this->getParent())) {
            return;
        }

        $path = $parent->getPath();

        if ($path) {
            if (strpos($this->key, '[') !== false) {
                list($p1, $p2) = explode('[', $this->key, 2);

                return "{$path}[{$p1}][{$p2}";
            }

            if ($this->key !== null) {
                return "{$path}[{$this->key}]";
            }

            return $path;
        }

        if ($this->key) {
            return $this->key;
        }
    }

    /**
     * Returns the element parent.
     *
     * @see FormManager\TreeInterface
     *
     * @return null|ElementInterface
     */
    abstract public function getParent();
}
