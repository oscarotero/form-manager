<?php
use FormManager\Inputs\Input;

class InputFileTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::file());
        $this->_testRequired(Input::file());
    }

    public function testError()
    {
        $input = Input::file();

        $input->val(array(
            'name' => 'image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__.'/image.jpg',
            'error' => 1,
        ));

        $this->assertFalse($input->isValid());
        $this->assertEquals('The uploaded file exceeds the upload_max_filesize directive in php.ini', $input->error());
    }

    public function testMimeType()
    {
        $input = Input::file();

        $input->accept('image/png');

        $input->val(array(
            'name' => 'image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => dirname(__DIR__).'/image.jpg',
            'error' => 0,
        ));

        $this->assertFalse($input->isValid());

        $input->accept('image/jpeg');

        $this->assertTrue($input->isValid(), $input->error());
    }
}
