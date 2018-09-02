<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\InputInterface;
use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class representing a form
 */
class Form extends Node implements ArrayAccess, IteratorAggregate
{
    private $inputs = [];

    public function __construct(array $inputs = [], array $attributes = [])
    {
        parent::__construct('form', $attributes);

        foreach ($inputs as $name => $input) {
            $this->offsetSet($name, $input);
        }
    }

    public function __clone()
    {
        foreach ($this->inputs as $k => $input) {
            $this->inputs[$k] = (clone $input)->setParentNode($this);
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->inputs);
    }

    public function offsetSet($name, $input)
    {
        if (!($input instanceof InputInterface)) {
            throw new InvalidArgumentException(
                sprintf('The input "%s" must be an instance of %s (%s)', $name, Input::class, gettype($input))
            );
        }

        $input->setName($name);
        $this->inputs[$name] = $input;
        $this->appendChild($input);
    }

    public function offsetGet($name)
    {
        return $this->inputs[$name] ?? null;
    }

    public function offsetUnset($name)
    {
        unset($this->inputs[$name]);
    }

    public function offsetExists($name)
    {
        return isset($this->inputs[$name]);
    }

    public function setValue($value): self
    {
        $value = (array) $value;

        foreach ($this->inputs as $name => $input) {
            $input->setValue($value[$name] ?? null);
        }

        return $this;
    }

    public function getValue()
    {
        $value = [];

        foreach ($this->inputs as $name => $input) {
            $value[$name] = $input->getValue();
        }

        return $value;
    }

    public function isValid(): bool
    {
        foreach ($this->inputs as $input) {
            if (!$input->isValid()) {
                return false;
            }
        }

        return true;
    }

    public function loadFromServerRequest(ServerRequestInterface $serverRequest): self
    {
        $method = $this->getAttribute('method') ?: 'get';

        if (strtolower($method) === 'post') {
            return $this->setValue(array_replace_recursive(
                (array) $serverRequest->getParsedBody(),
                $serverRequest->getUploadedFiles()
            ));
        }

        return $this->setValue($serverRequest->getQueryParams());
    }

    public function loadFromArrays(array $get, array $post = [], array $files = []): self
    {
        $method = $this->getAttribute('method') ?: 'get';

        if (strtolower($method) === 'post') {
            return $this->setValue(array_replace_recursive($post, $files));
        }

        return $this->setValue($get);
    }

    public function loadFromGlobals(): self
    {
        return $this->loadFromArrays($_GET, $_POST, $_FILES);
    }
}
