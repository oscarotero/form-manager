<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\File;
use PHPUnit\Framework\TestCase;
use Nyholm\Psr7\UploadedFile;

class FileTest extends TestCase
{
    public function valuesProvider(): array
    {
        $file = dirname(__DIR__).'/image.jpg';
        $size = filesize($file);

        $psr7_file = new UploadedFile($file, $size, 0, 'image.jpg', 'image/jpeg');

        $array_file = [
            'name' => 'image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => $file,
            'size' => $size,
            'error' => null,
        ];

        return [
            [true, null],
            [false, null, ['required' => true]],
            [false, [], ['required' => true]],
            [false, ['error' => 1] + $array_file],
            [true, $psr7_file],
            [true, $array_file],
            [true, ['error' => 99] + $array_file],
            [false, $array_file, ['accept' => '.png']],
            [true, $array_file, ['accept' => '.jpg']],
            [false, $array_file, ['accept' => 'image/png']],
            [true, $array_file, ['accept' => 'image/jpeg']],
            [false, $psr7_file, ['accept' => 'image/png']],
            [true, $psr7_file, ['accept' => 'image/jpeg']],
            [true, $psr7_file, ['accept' => '.png,image/jpeg,.jpeg,.jpg']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes = [])
    {
        $input = new File();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new File();
        $this->assertSame('<input type="file">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="file" id="foo">',
            (string) $input
        );
    }

    public function errorProvider()
    {
        $file = dirname(__DIR__).'/image.jpg';
        $size = filesize($file);

        $psr7_file = new UploadedFile($file, $size, 0, 'image.jpg', 'image/jpeg');

        return [
            [
                null,
                'This value should not be blank.'
            ],
            [
                null,
                'This is required!',
                ['required' => 'This is required!']
            ],
            [
                'foo',
                'This value is not a valid file.',
            ],
            [
                'foo',
                'Not valid file',
                ['file' => 'Not valid file']
            ],
            [
                $psr7_file,
                'This file type is not valid.',
            ],
            [
                $psr7_file,
                'Only png files are supported',
                ['accept' => 'Only png files are supported']
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new File(null, [
            'required' => true,
            'accept' => 'image/png',
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
