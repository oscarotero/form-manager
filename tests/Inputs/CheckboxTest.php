<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Checkbox;
use PHPUnit\Framework\TestCase;

class CheckboxTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, [], null],
            [false, null, ['required' => true], null],
            [true, 'on', ['required' => true], true],
            [true, 1, ['required' => true], true],
            [true, '1', ['required' => true], true],
            [true, '0', [], null],
            [true, 0, [], null],
            [true, true, ['required' => true], true],
            [false, false, ['required' => true], null],
            [false, 'foo', ['required' => true], null],
            [true, 'on', ['required' => true, 'value' => 'foo'], true],
            [true, 'foo', ['required' => true, 'value' => 'foo'], true],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes, ?bool $expectedValue)
    {
        $input = new Checkbox();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
        $this->assertSame($expectedValue, $input->value);

        if ($expectedValue) {
            $this->assertTrue($input->checked);
        } else {
            $this->assertNull($input->checked);
        }
    }

    public function testRender()
    {
        $input = new Checkbox();
        $this->assertSame('<input type="checkbox" value="on">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<input type="checkbox" value="on" id="foo"> <label for="foo">Click here</label>',
            (string) $input
        );
    }

    public function errorProvider()
    {
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
        ];
    }

    /**
     * @dataProvider errorProvider
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Checkbox(null, [
            'required' => true,
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
