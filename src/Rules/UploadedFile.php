<?php
declare(strict_types = 1);

namespace FormManager\Rules;

use Respect\Validation\Rules\AbstractRule;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFile extends AbstractRule
{
    const ERROR_TYPES = [
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
    ];

    public function validate($input)
    {
        if (is_array($input)) {
            return $this->validateArray($input);
        }

        if ($input instanceof UploadedFileInterface) {
            return $this->validatePsr7($input);
        }

        return false;
    }

    private function validateArray(array $file)
    {
        if (!array_key_exists('name', $file)) {
            return false;
        }

        if (!array_key_exists('type', $file)) {
            return false;
        }

        if (!array_key_exists('tmp_name', $file)) {
            return false;
        }

        return $this->checkErrorType($file['error'] ?? null);
    }

    private function validatePsr7(UploadedFileInterface $file)
    {
        return $this->checkErrorType($file->getError());
    }

    private function checkErrorType($error): bool
    {
        return !isset($error) || !isset(self::ERROR_TYPES[$error]);
    }
}
