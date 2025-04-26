<?php
declare(strict_types=1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Radio;
use PHPUnit\Framework\TestCase;

class RadioTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, [], null],
            [false, null, ['required' => true], null],
            [true, 'blue', ['value' => 'blue', 'required' => true], 'blue'],
            [false, 'blue', ['value' => 'red', 'required' => true], null],
        ];
    }

    /**
     * @dataProvider valuesProvider
     * @param mixed $value
     */
    public function testInput(bool $isValid, $value, array $attributes, ?string $expectedValue)
    {
        $input = new Radio();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());

        if ($expectedValue) {
            $this->assertTrue($input->checked);
        } else {
            $this->assertNull($input->checked);
        }
    }

    public function testRender()
    {
        $input = new Radio();
        $this->assertSame('<input type="radio">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<input type="radio" id="foo"> <label for="foo">Click here</label>',
            (string) $input
        );
    }

    public function errorProvider()
    {
        return [
            [
                null,
                'This value should not be blank.',
            ],
            [
                null,
                'This is required!',
                ['required' => 'This is required!'],
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     * @param mixed $value
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Radio(null, [
            'required' => true,
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
