<?php

use FormManager\Builder;

class LocalesTest extends BaseTest
{
    public function testLocales()
    {
        $input = Builder::text()->required();
        $message = 'custom error message';

        FormManager\Validators\Required::$error_message = $message;

        $this->assertFalse($input->validate());

        $this->assertEquals($message, $input->error());
    }
}
