<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use FormManager\ValidatorFactory;
use FormManager\Inputs\Text;

class ValidatorFactoryTest extends TestCase
{
    protected function tearDown(): void
    {
        ValidatorFactory::setMessages([]);
    }

    public function testSetMessages(): void
    {
        ValidatorFactory::setMessages([
            'required' => 'Default required message',
        ]);

        $input = new Text('Test input');
        $input->setAttribute('required', true);
        $input->setValue('');

        $this->assertEquals('Default required message', (string) $input->getError());
    }

    public function testCustomMessage(): void
    {
        ValidatorFactory::setMessages([
            'required' => 'Default required message',
        ]);

        $input = new Text('Test input');
        $input->setAttribute('required', true);
        $input->setValue('');
        $input->setErrorMessages([
            'required' => 'Custom required message',
        ]);

        $this->assertEquals('Custom required message', (string) $input->getError());
    }
}
