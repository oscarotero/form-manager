<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class File extends Input implements InputInterface
{
	protected static $uploadErrors = array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder'
	);

    protected $value;
    protected $attributes = ['type' => 'file'];


    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->value;
        }

        $this->value = $value;

        return $this;
    }


    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        return parent::load($file);
    }


    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $value = $this->val();

        if (isset(self::$uploadErrors[$value['error']])) {
        	$this->error(self::$uploadErrors[$value['error']]);

        	return false;
        }

        return parent::validate();
    }
}
