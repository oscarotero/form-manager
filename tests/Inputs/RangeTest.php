<?php
declare(strict_types=1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Range;

class RangeTest extends NumberTest
{
    /**
     * @dataProvider valuesProvider
     * @param mixed $value
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Range();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Range();
        $this->assertSame('<input type="range">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="range" id="foo">',
            (string) $input
        );
    }

    /**
     * @dataProvider errorProvider
     * @param mixed $value
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Range(null, [
            'required' => true,
            'min' => 1,
            'max' => 10,
            'step' => 5,
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }

    public function testDecimalStep()
    {
        $input = new Range(null, [
            'min' => 1,
            'max' => 10,
            'step' => 0.5,
            'value' => 5,
        ]);

        $this->assertTrue($input->isValid());
    }
}
