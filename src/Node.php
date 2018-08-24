<?php
declare(strict_types = 1);

namespace FormManager;

/**
 * Class representing a generic HTML node element
 */
class Node
{
    const SELF_CLOSING_TAGS = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr'
    ];

    private $nodeName;
    private $parentNode;
    private $childNodes = [];
    private $attributes = [];
    private $variables = [];

    public $innerHtml;

    public function __construct(string $nodeName)
    {
        $this->nodeName = $nodeName;
    }

    public function __toString()
    {
        try {
            if ($this->childNodes) {
                return $this->getOpeningTag().implode('', $this->childNodes).$this->getClosingTag();
            }

            return $this->getOpeningTag().$this->innerHtml.$this->getClosingTag();
        } catch (\Exception $exception) {
            return '<pre>'.(string) $exception.'</pre>';
        }
    }

    public function __clone()
    {
        $this->removeAttribute('id');

        foreach ($this->childNodes as $k => $child) {
            $this->childNodes[$k] = clone $child;
            $this->childNodes[$k]->parentNode = $this;
        }
    }

    public function __get(string $name)
    {
        return $this->getAttribute($name);
    }

    public function __set(string $name, $value)
    {
        $this->setAttribute($name, $value);
    }

    public function getNodeName(): string
    {
        return $this->nodeName;
    }

    public function getParentNode(): ?Node
    {
        return $this->parentNode;
    }

    public function getChildNodes(): array
    {
        return $this->childNodes;
    }

    public function appendChild(Node $node): self
    {
        $this->childNodes[] = $node;
        $node->parentNode = $this;

        return $this;
    }

    public function setAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function removeAttribute($name): self
    {
        unset($this->attributes[$name]);

        return $this;
    }

    /**
     * Set an arbitrary variable.
     */
    public function setVariable(string $name, $value = null): self
    {
        $this->variables[$name] = $value;

        return $this;
    }

    /**
     * Get an arbitrary variable.
     */
    public function getVariable(string $name)
    {
        return $this->variables[$name] ?? null;
    }

    /**
     * Returns the html code of the opening tag.
     */
    public function getOpeningTag(): string
    {
        $attributes = [];

        foreach ($this->attributes as $name => $value) {
            $attributes[] = static::getHtmlAttribute($name, $value);
        }

        $attributes = implode(' ', $attributes);

        return sprintf('<%s%s>', $this->nodeName, $attributes === '' ? '' : " {$attributes}");
    }

    /**
     * Returns the html code of the closing tag.
     */
    public function getClosingTag(): ?string
    {
        if (!in_array($this->nodeName, self::SELF_CLOSING_TAGS)) {
            return sprintf('</%s>', $this->nodeName);
        }

        return null;
    }

    /**
     * Escapes an attribute value.
     */
    protected static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Creates a html attribute.
     */
    private static function getHtmlAttribute(string $name, $value): string
    {
        if (($value === null) || ($value === false)) {
            return '';
        }

        if ($value === true) {
            return $name;
        }

        if (is_array($value)) {
            switch ($name) {
                case 'class':
                case 'aria-labelledby':
                    $value = implode(' ', $value);
                    break;

                case 'accept':
                case 'accept-charset':
                    $value = implode(', ', $value);
                    break;

                default:
                    $value = json_encode($value);
                    break;
            }
        }

        return sprintf('%s="%s"', $name, static::escape($value));
    }
}
