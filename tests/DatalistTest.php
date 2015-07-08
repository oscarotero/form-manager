<?php
use FormManager\Builder;

class DatalistTest extends BaseTest
{
    public function testOne()
    {
        $input = Builder::text()->datalist(['Hello' => 'World'])->id('my-id');
        $input->datalist->id('my-datalist-id');

        $this->assertEquals('my-id', $input->attr('id'));
        $this->assertEquals(' <input type="text" id="my-id" list="my-datalist-id"><datalist id="my-datalist-id"><option value="Hello">World</option></datalist> ', (string) $input);
    }
}
