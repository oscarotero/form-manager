<?php

namespace FormManager\Traits;

/**
 * Trait with common methods for custom render.
 */
trait RenderTrait
{
    public $wrapper;

    private $render;
    private $rendering; 

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function render(callable $render)
    {
        $this->render = $render;

        return $this;
    }

    /**
     * Return the element as html string.
     *
     * @param string $prepend Optional string prepended to html content
     * @param string $append  Optional string appended to html content
     *
     * @return string
     */
    public function toHtml($prepend = '', $append = '')
    {
        if ($this->rendering) {
            throw new \RuntimeException('Recursive rendering');
        }

        $this->rendering = true;

        if (empty($this->render)) {
            $html = $this->defaultRender($prepend, $append);
        } else {
            $html = call_user_func($this->render, $this, $prepend, $append);
        }

        $this->rendering = false;

        if (empty($this->wrapper)) {
            return $html;
        }

        return $this->wrapper->toHtml($html);
    }

    /**
     * The default render used if no custom render is provided.
     *
     * @param string $prepend Optional string prepended to html content
     * @param string $append  Optional string appended to html content
     *
     * @return string
     */
    abstract protected function defaultRender($prepend = '', $append = '');
}
