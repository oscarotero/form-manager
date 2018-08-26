<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use Respect\Validation\Validator as v;
use FormManager\Inputs\Month;
use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            // https://github.com/Respect/Validation/issues/1083
            // [false, '2014-13', []],
            [true, '2014-09', []],
            [false, '2014-09', ['max' => '2014-08']],
            [true, '2014-09', ['max' => '2014-09']],
            [false, '2014-09', ['min' => '2014-10']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Month();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }
}
