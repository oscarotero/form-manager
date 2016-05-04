<?php

namespace FormManager\Fields;

use Psr\Http\Message\ServerRequestInterface;
use FormManager\Elements\Fieldset;

class Form extends Group
{
    protected $name = 'form';
    protected $fieldsets = [];

    /**
     * Load the form values from global GET, POST, FILES values.
     *
     * @param array|null $get
     * @param array|null $post
     * @param array|null $files
     *
     * @return self
     */
    public function loadFromGlobals(array $get = null, array $post = null, array $files = null)
    {
        if (strtolower($this->attr('method')) === 'post') {
            $values = ($post === null) ? $_POST : $post;
            $files = self::fixFilesArray(($files === null) ? $_FILES : $files);

            $values = array_replace_recursive($values, $files);
        } else {
            $values = ($get === null) ? $_GET : $get;
        }

        return $this->load($values);
    }

    /**
     * Load the form values from a PSR-7 ServerRequest.
     *
     * @param ServerRequestInterface $request
     *
     * @return self
     */
    public function loadFromPsr7(ServerRequestInterface $request)
    {
        if (strtolower($this->attr('method')) === 'post') {
            $values = $request->getParsedBody();
            $files = $request->getUploadedFiles();

            $values = array_replace_recursive($values, $files);
        } else {
            $values = $request->getQueryParams();
        }

        return $this->load($values);
    }

    /**
     * Fix the $files order by converting from default wierd schema
     * [first][name][second][0], [first][error][second][0]...
     * to a more straightforward one.
     * [first][second][0][name], [first][second][0][error]...
     *
     * @param array $files An array with all files values
     *
     * @return array The files values fixed
     */
    public static function fixFilesArray($files)
    {
        if (isset($files['name'], $files['tmp_name'], $files['size'], $files['type'], $files['error'])) {
            return self::moveToRight($files);
        }

        foreach ($files as &$file) {
            $file = self::fixFilesArray($file);
        }

        return $files;
    }

    /**
     * Private function used by fixFilesArray.
     *
     * @param array $files An array with all files values
     *
     * @return array The files values fixed
     */
    private static function moveToRight($files)
    {
        if (!is_array($files['name'])) {
            //avoid no uploads
            if ($files['error'] === 4) {
                return;
            }

            return $files;
        }

        $results = [];

        foreach ($files['name'] as $index => $name) {
            $reordered = [
                'name' => $files['name'][$index],
                'tmp_name' => $files['tmp_name'][$index],
                'size' => $files['size'][$index],
                'type' => $files['type'][$index],
                'error' => $files['error'][$index],
            ];

            if (is_array($name)) {
                $reordered = self::moveToRight($reordered);
            }

            $results[$index] = $reordered;
        }

        return $results;
    }

    /**
     * Set/Get the available fieldsets in this form.
     *
     * @param null|array $fieldsets null to getter, array to setter
     *
     * @return mixed
     */
    public function fieldsets(array $fieldsets = null)
    {
        if ($fieldsets === null) {
            return $this->fieldsets;
        }

        foreach ($fieldsets as $name => $fieldset) {
            if (!($fieldset instanceof Fieldset)) {
                $fieldset = (new Fieldset())->add($fieldset);
            }

            $this->fieldsets[$name] = $fieldset->setParent($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->fieldsets = [];

        return parent::clear();
    }

    /**
     * {@inheritdoc}
     */
    public function html($html = null)
    {
        if ($html !== null) {
            parent::html($html);
        }

        $html = '';

        //render the children not belonging to a fieldset
        foreach ($this->children as $fieldset) {
            if ($fieldset->getParent() === $this) {
                $html .= (string) $fieldset;
            }
        }

        //render the fieldsets
        if (!empty($this->fieldsets)) {
            foreach ($this->fieldsets as $fieldset) {
                $html .= (string) $fieldset;
            }
        }

        return $html;
    }
}
