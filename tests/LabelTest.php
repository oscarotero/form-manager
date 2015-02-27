<?php
use FormManager\Builder;

class LabelTest extends BaseTest
{
    public function testOne()
    {
        $input = Builder::text()->label('Hello')->id('my-id');

        $this->assertEquals('my-id', $input->attr('id'));
        $this->assertEquals('<label for="my-id">Hello</label> <input type="text" id="my-id"> ', (string) $input);
    }

    public function testTwo()
    {
        $input = Builder::text()->id('my-id')->label('Hello');

        $this->assertEquals('my-id', $input->attr('id'));
        $this->assertEquals('<label for="my-id">Hello</label> <input type="text" id="my-id"> ', (string) $input);
    }
}
