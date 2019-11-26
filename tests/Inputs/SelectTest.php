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
     * @param mixed $value
     * @param mixed $expectedValue
     */
    public function testInput(bool $isValid, $value, array $attributes, $expectedValue)
    {
        $input = new Select(null, [
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

    public function testOptgroups()
    {
        $select = (new Select())->setOptgroups([
            'Section 1' => [
                1 => 'One',
                2 => 'Two',
            ],
            'Section 2' => [
                3 => 'Three',
                4 => 'Four',
            ],
        ]);

        $this->assertCount(2, $select->getChildNodes());
        $select->value = 3;
        $this->assertSame(3, $select->value);

        $expetedHtml = '<select><optgroup label="Section 1"><option value="1">One</option><option value="2">Two</option></optgroup><optgroup label="Section 2"><option value="3" selected>Three</option><option value="4">Four</option></optgroup></select>';

        $this->assertSame($expetedHtml, (string) $select);
    }

    public function testAllowNewValues()
    {
        $select = new Select();
        $select->allowNewValues();
        $select->multiple = true;
        $select->value = ['one', 2];

        $this->assertCount(2, $select->getChildNodes());

        list($one, $two) = $select->getChildNodes();

        $this->assertSame('one', $one->value);
        $this->assertSame('one', $one->innerHTML);

        $this->assertSame(2, $two->value);
        $this->assertSame('2', $two->innerHTML);

        $this->assertEquals(['one', 2], $select->value);

        $select->allowNewValues(false);
        $select->value = [3];
        $this->assertEquals([], $select->value);
    }

    public function testRender()
    {
        $input = (new Select())->setOptions(['foo' => 'bar']);
        $this->assertSame('<select><option value="foo">bar</option></select>', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <select id="foo"><option value="foo">bar</option></select>',
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
        $input = new Select(
            null,
            [
                1 => 'One',
            ],
            [
                'required' => true,
            ]
        );

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
