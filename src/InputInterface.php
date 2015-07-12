<?php
namespace FormManager;

use FormManager\Elements\Datalist;

/**
 * Interface used by all input elements
 */
interface InputInterface extends ContainerInterface
{
    /**
     * Set the datalist associated with this input
     *
     * @param Datalist $datalist
     * 
     * @return self
     */
    public function setDatalist(Datalist $datalist);
}
