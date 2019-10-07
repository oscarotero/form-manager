<?php
declare(strict_types = 1);

namespace FormManager\Tests;

use FormManager\Form;
use FormManager\Inputs\Text;
use FormManager\Groups\Group;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use ArrayIterator;
use Psr\Http\Message\ServerRequestInterface;

class FormTest extends TestCase
{
    protected $form;

    public function setUp()
    {
        $this->form =  new Form([
            'text' => (new Text('Name'))->setValue('Oscar'),
            'address' => new Group([
                'line1' => (new Text('Line 1'))->setValue('Santaia de Gorgullos'),
                'line2' => (new Text('Line 2'))->setValue('Tordoia'),
            ]),
        ]);
    }

    public function testBasicMethods()
    {
        $form = $this->form;

        $this->assertInstanceof(Text::class, $form['text']);
        $this->assertInstanceof(Group::class, $form['address']);
        $this->assertInstanceof(Text::class, $form['address']['line1']);
        $this->assertSame('address[line1]', $form['address']['line1']->getAttribute('name'));
        $this->assertSame(
            [
                'text' => 'Oscar',
                'address' => [
                    'line1' => 'Santaia de Gorgullos',
                    'line2' => 'Tordoia',
                ],
            ],
            $form->getValue()
        );
    }

    public function testOffsetUnset()
    {
        $form = $this->form;
        $form->offsetUnset('address');

        $this->assertEquals([
            'text' => 'Oscar',
        ], $form->getValue());
    }

    public function testOffsetExists()
    {
        $this->assertEquals(true, $this->form->offsetExists('text'));
    }

    public function testSetValue()
    {
        $newValue = [
            'text' => 'Beta',
            'address' => [
                'line1' => 'test',
                'line2' => 'test',
            ]
        ];
        $form = $this->form;
        $form->setValue($newValue);

        $this->assertEquals($newValue, $form->getValue());
    }

    public function testIsValidFalse()
    {

        $input1 = $this->createMock(Text::class);
        $input2 = $this->createMock(Text::class);

        $input1->expects($this->any())->method('isValid')->willReturn(false);
        $input2->expects($this->any())->method('isValid')->willReturn(true);

        $form = new Form([
            'text' => $input1,
            'test' => $input2]
        );

        $this->assertEquals(false, $form->isValid());
    }

    public function testIsValidTrue()
    {

        $input1 = $this->createMock(Text::class);
        $input2 = $this->createMock(Text::class);

        $input1->expects($this->any())->method('isValid')->willReturn(true);
        $input2->expects($this->any())->method('isValid')->willReturn(true);

        $form = new Form([
                'text' => $input1,
                'test' => $input2]
        );

        $this->assertEquals(true, $form->isValid());
    }

    public function testClone()
    {
        $this->assertEquals(
            $this->form->getValue(),
            (clone $this->form)->getValue()
        );
    }

    public function testOffsetSetWithWrongClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->form->offsetSet('test', new Form());
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf(ArrayIterator::class, $this->form->getIterator());
    }


    public function testLoadFromServerRequestGET()
    {
        $this->form->setAttribute('method', 'get');
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getQueryParams');
        $this->assertInstanceOf(Form::class, $this->form->loadFromServerRequest($request));
    }

    public function testLoadFromServerRequestPOST()
    {
        $this->form->setAttribute('method', 'post');
        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getParsedBody')->willReturn([]);
        $request->expects($this->once())->method('getUploadedFiles')->willReturn([]);
        $this->assertInstanceOf(Form::class, $this->form->loadFromServerRequest($request));
    }

    public function testLoadFromGlobals()
    {
        $this->form->setAttribute('method', 'get');
        $this->assertInstanceOf(Form::class, $this->form->loadFromGlobals());
    }

    public function testLoadFromArray()
    {
        $this->form->setAttribute('method', 'post');
        $this->assertInstanceOf(Form::class, $this->form->loadFromArrays([],[],[]));
    }
}
