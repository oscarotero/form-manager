<?php
namespace FormManager;

use FormManager\Elements\Datalist;
use FormManager\Elements\Label;

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

    /**
     * Add a new label to this input
     *
     * @param Label $label
     *
     * @return self
     */
    public function addLabel(Label $label);

    /**
     * Remove the label from this input
     *
     * @param Label $label
     *
     * @return self
     */
    public function removeLabel(Label $label);
}
