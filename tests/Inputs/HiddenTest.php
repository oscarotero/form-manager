<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Hidden;
use PHPUnit\Framework\TestCase;

class HiddenTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Hidden();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Hidden();
        $this->assertSame('<input type="hidden">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<input type="hidden" id="foo">',
            (string) $input
        );
    }
}
