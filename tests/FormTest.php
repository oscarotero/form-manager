<?php
declare(strict_types = 1);

namespace FormManager\Tests;

use FormManager\Form;
use FormManager\Inputs\Text;
use FormManager\Groups\Group;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testBasicMethods()
    {
        $form = new Form([
            'text' => (new Text('Name'))->setValue('Oscar'),
            'address' => new Group([
                'line1' => (new Text('Line 1'))->setValue('Santaia de Gorgullos'),
                'line2' => (new Text('Line 2'))->setValue('Tordoia'),
            ]),
        ]);

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
}
