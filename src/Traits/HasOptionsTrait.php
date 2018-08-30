<?php
declare(strict_types = 1);

namespace FormManager\Traits;

use FormManager\Node;
use FormManager\NodeInterface;

/**
 * Common utilities for elements containing <option> and <optgroup> (like selects and datalist)
 */
trait HasOptionsTrait
{
    private $options = [];

    abstract public function appendChild(NodeInterface $node): Node;

    private function addOptions(iterable $options)
    {
        foreach ($options as $value => $text) {
            if (is_array($text)) {
                $this->addOptgroup($value, $text);
                continue;
            }

            $this->addOption($value, (string) $text);
        }
    }

    private function addOptgroup($label, iterable $options)
    {
        $optgroup = new Node('optgroup', compact('label'));

        foreach ($options as $value => $label) {
            $this->addOption($value, $label, $optgroup);
        }

        $this->appendChild($optgroup);
    }

    private function addOption($value, string $label = null, Node $parent = null)
    {
        $option = new Node('option', compact('value'));
        $option->innerHTML = $label ?: (string) $value;

        $this->options[] = $option;

        if ($parent) {
            $parent->appendChild($option);
        } else {
            $this->appendChild($option);
        }
    }
}
