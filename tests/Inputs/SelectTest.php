<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Select;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, [], ''],
            [false, null, ['required' => true], ''],
            [false, '', ['required' => true], ''],
            [false, 'foo', ['required' => true], null],
            [false, 0, ['required' => true], null],
            [false, 0, ['required' => true], null],
            [true, 1, ['required' => true], 1],
            [true, '1', ['required' => true], 1],
            [true, 2, ['required' => true], 2],
            [true, 't', ['required' => true], 't'],
            [true, '04', [], '04'],
            [false, 4, ['required' => true], null],
            [true, 't', ['required' => true, 'multiple' => true], ['t']],
            [true, ['t', 1], ['required' => true, 'multiple' => true], [1, 't']],
            [false, null, ['required' => true, 'multiple' => true], []],
            [false, [], ['required' => true, 'multiple' => true], []],
            [true, [], ['multiple' => true], []],
            [true, 1, ['multiple' => true], [1]],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes, $expectedValue)
    {
        $input = new Select([
            '' => 'Empty',
            1 => 'One',
            '2' => 'Two',
            't' => 'Three',
            '04' => 'Four',
        ]);

        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
        $this->assertSame($expectedValue, $input->value);
    }
}
