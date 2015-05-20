<?php
namespace FormManager\Containers;

class Form extends Group
{
    protected $name = 'form';

    /**
     * Load the form values from global GET, POST, FILES values.
     *
     * @param array|null $get
     * @param array|null $post
     * @param array|null $files
     *
     * @return $this
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

    /**
     * Checks if the form was sent.
     *
     * @return true|false
     */
    public function isSent() {
        return (strtolower($this->attr('method')) === 'post' && strtolower($_SERVER['REQUEST_METHOD']) == 'post') || isset($_GET['submit']);
    }
}
