<?php
declare(strict_types = 1);

namespace FormManager\Validators;

use Psr\Http\Message\UploadedFileInterface;

class AcceptFile
{
    private $options = [];
    private $extensions = [];
    private $mimes = [];

    public function __construct(array $options = [])
    {
        $this->options = $options + [
            'message' => 'This file type is not valid.',
        ];

        $accept = array_map('trim', explode(',', strtolower($this->options['accept'])));

        $this->extensions = array_filter($accept, function ($value) {
            return !strstr($value, '/');
        });

        $this->mimes = array_filter($accept, function ($value) {
            return strstr($value, '/');
        });

        array_walk($this->mimes, function (&$value) {
            $value = strtolower(str_replace('*', '.*', "|^{$value}\$|"));
        });
    }

    public function __invoke($input, $context)
    {
        if (empty($input)
            || (is_array($input) && $this->validateArray($input))
            || ($input instanceof UploadedFileInterface && $this->validatePsr7($input))
        ) {
            return;
        }

        $context->buildViolation($this->options['message'])->addViolation();
    }

    private function validateArray(array $file): bool
    {
        if (empty($file['tmp_name'])) {
            return true;
        }

        return $this->checkExtension($file['name'])
            && $this->checkMime($file['tmp_name']);
    }

    private function validatePsr7(UploadedFileInterface $file): bool
    {
        if ($file->getError() === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        return $this->checkExtension($file->getClientFilename())
            && $this->checkMime($file->getStream()->getMetadata('uri'));
    }

    private function checkExtension(string $name): bool
    {
        if (empty($this->extensions)) {
            return true;
        }

        $original = explode('.', $name);
        $original = '.'.end($original);

        foreach ($this->extensions as $extension) {
            if ($original === $extension) {
                return true;
            }
        }

        return false;
    }

    private function checkMime(string $file): bool
    {
        if (empty($this->mimes)) {
            return true;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);

        foreach ($this->mimes as $pattern) {
            if (preg_match($pattern, $mime)) {
                return true;
            }
        }

        return false;
    }
}
