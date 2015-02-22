<?php
use FormManager\Inputs\Input;

class LocalesTest extends BaseTest
{
    public function testLocales()
    {
        $input = Input::text()->required();
        $message = 'custom error message';

        FormManager\Attributes\Required::$error_message = $message;

        $this->assertFalse($input->isValid());

        $this->assertEquals($message, $input->error());
    }
}
