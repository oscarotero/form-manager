<?php
namespace FormManager\Traits;

/**
 * Trait with common methods for custom render.
 */
trait RenderTrait
{
    protected $render;
    protected $rendering = false;

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
        if ($this->rendering === false) {
            $this->rendering = true;

            if ($this->render) {
                $html = call_user_func($this->render, $this, $prepend, $append);
            } else {
                $html = $this->customRender($prepend, $append);
            }

            $this->rendering = false;

            return $html;
        }

        return $this->defaultRender($prepend, $append);
    }

    /**
     * The custom render used on extend this object
     *
     * @param string $prepend Optional string prepended to html content
     * @param string $append  Optional string appended to html content
     *
     * @return string
     */
    protected function customRender($prepend = '', $append = '')
    {
        return $this->defaultRender($prepend, $append);
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
