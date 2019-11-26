<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Tel;

class TelTest extends TextTest
{
    /**
     * @dataProvider valuesProvider
     * @param mixed $value
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Tel();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Tel();
        $this->assertSame('<input type="tel">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="tel" id="foo">',
            (string) $input
        );
    }

    /**
     * @dataProvider errorProvider
     * @param mixed $value
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Tel(null, [
            'required' => true,
            'minlength' => 15,
            'maxlength' => 20,
            'pattern' => '.*baz',
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
