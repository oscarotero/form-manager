<?php
declare(strict_types=1);

namespace FormManager;

/**
 * Interface representing a basic node element
 */
interface NodeInterface
{
    public function getParentNode(): ?NodeInterface;

    public function setParentNode(NodeInterface $parentNode): NodeInterface;

    public function __toString();
}
