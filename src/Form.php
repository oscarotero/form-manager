<?php
namespace FormManager;

use FormManager\Traits\ParentTrait;
use FormManager\Traits\ValidationTrait;
use FormManager\Traits\VarsTrait;
use Iterator;
use ArrayAccess;

class Form extends Element implements Iterator, ArrayAccess, FormElementInterface
{
    use ParentTrait;
    use ValidationTrait;
    use VarsTrait;

    protected $name = 'form';
    protected $close = true;

    /**
     * Load the form values from global GET, POST, FILES values
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
            $value = ($post === null) ? $_POST : $post;
        } else {
            $value = ($get === null) ? $_GET : $get;
        }

        if ($files === null) {
            $files = self::fixFilesArray($_FILES);
        }

        return $this->load($value, $files);
    }

    /**
     * {@inheritDoc}
     */
    public function html($html = null)
    {
        if ($html === null) {
            return $this->html.$this->childrenToHtml();
        }

        return parent::html($html);
    }

    /**
     * {@inheritDoc}
     */
    public function id($id = null)
    {
        return $this->attr('id', $id);
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
     * Private function used by fixFilesArray
     *
     * @param array $files An array with all files values
     *
     * @return array The files values fixed
     */
    private static function moveToRight($files)
    {
        if (!is_array($files['name'])) {
            return $files;
        }

        $results = array();

        foreach ($files['name'] as $index => $name) {
            $reordered = array(
                'name' => $files['name'][$index],
                'tmp_name' => $files['tmp_name'][$index],
                'size' => $files['size'][$index],
                'type' => $files['type'][$index],
                'error' => $files['error'][$index],
            );

            if (is_array($name)) {
                $reordered = self::moveToRight($reordered);
            }

            $results[$index] = $reordered;
        }

        return $results;
    }
}
