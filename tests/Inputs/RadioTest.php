<?php
declare(strict_types = 1);

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
}
