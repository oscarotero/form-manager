<?php

use FormManager\Builder;
use FormManager\Factory;

class BuilderTest extends BaseTest
{
    protected $builder;
    protected $emptyBuilder;

    public function setUp()
    {
        $this->builder = new Builder(new Factory());
        $this->emptyBuilder = new Builder();
    }

    public function types()
    {
        return [
            ['Checkbox'],
            ['Color'],
            ['Date'],
            ['Datetime'],
            ['DatetimeLocal'],
            ['Email'],
            ['File'],
            ['Hidden'],
            ['Month'],
            ['Number'],
            ['Password'],
            ['Radio'],
            ['Range'],
            ['Search'],
            ['Select'],
            ['Submit'],
            ['Tel'],
            ['Text'],
            ['Textarea'],
            ['Time'],
            ['Url'],
            ['Week'],
        ];
    }

    /**
     * @dataProvider types
     */
    public function testBuilders($type)
    {
        $static = Builder::$type();
        $instance = call_user_func([$this->builder, $type]);
        $null = call_user_func([$this->emptyBuilder, $type]);

        $this->assertInstanceOf('FormManager\\Fields\\'.$type, $static);
        $this->assertInstanceOf('FormManager\\Fields\\'.$type, $instance);
        $this->assertNull($null);
    }
}
