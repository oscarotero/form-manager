<?php

namespace FormManager\Elements;

use Psr\Http\Message\UploadedFileInterface;
use FormManager\InputInterface;

class InputFile extends Input implements InputInterface
{
    protected $attributes = ['type' => 'file'];
    protected $value;

    public function __construct()
    {
        $this->addValidator(\FormManager\Validators\File::class, 'FormManager\\Validators\\File::validate');
    }

    /**
     * @see FormManager\InputInterface
     *
     * {@inheritdoc}
     */
    public function load($value = null)
    {
        $this->val($value ?: '');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->value;
        }

        $error = null;

        if ($value instanceof UploadedFileInterface) {
            $error = $value->getError();
        } elseif (isset($value['error'])) {
            $error = $value['error'];
        }

        if ($error === UPLOAD_ERR_NO_FILE) {
            $value = null;
        }

        $this->value = $value;

        return $this;
    }
}
