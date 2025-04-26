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

    public function setOptgroups(iterable $optgroups): self
    {
        $this->options = [];

        foreach ($optgroups as $label => $options) {
            $this->appendChild($this->createOptgroup($label, $options));
        }

        return $this;
    }

    public function setOptions(iterable $options): self
    {
        $this->options = [];

        foreach ($options as $value => $label) {
            $attributes = [];

            if (is_array($label)) {
                $attributes = $label;
                $label = $attributes['label'] ?? $value;
                unset($attributes['label']);
            }

            $this->appendChild($this->createOption($value, (string) $label)->setAttributes($attributes));
        }

        return $this;
    }

    private function createOptgroup($label, iterable $options): Node
    {
        $optgroup = new Node('optgroup', compact('label'));

        foreach ($options as $value => $label) {
            $optgroup->appendChild($this->createOption($value, $label));
        }

        return $optgroup;
    }

    private function createOption($value, ?string $label = null): Node
    {
        $option = new Node('option', compact('value'));
        $option->innerHTML = $label ?: (string) $value;

        return $this->options[] = $option;
    }
}
