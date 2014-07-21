<?php
/**
 * Trait with common methods of all child elements (elements inside the form)
 */

namespace FormManager\Traits;

use FormManager\InputInterface;

trait ChildTrait
{
    protected $parent;

    /**
	 * Set the element parent
	 *
	 * @param InputInterface $parent
	 *
	 * @return $this
	 */
    public function setParent(InputInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
	 * Returns the element parent
	 *
	 * @return null|InputInterface
	 */
    public function getParent()
    {
        return $this->parent;
    }
}
