<?php
namespace FormManager\Containers;

use FormManager\FormElementInterface;

class Group extends Container
{
    /**
     * {@inheritdoc}
     */
    public function prepareChild(FormElementInterface $child, $key, $parentPath = null)
    {
        $path = $parentPath ? "{$parentPath}[{$key}]" : $key;

        if ($child instanceof Container) {
            foreach ($child as $k => $grandchild) {
                if ($grandchild instanceof Container) {
                    $grandchild->prepareChild($child, $k, $path);
                } else {
                    $grandchild->attr('name', $path);
                }
            }
        } else {
            $child->attr('name', $path);
        }
    }
}
