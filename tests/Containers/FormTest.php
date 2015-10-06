<?php

use FormManager\Builder;
use FormManager\Containers\Form;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\UploadedFile;

class FormTest extends BaseTest
{
    public function testBase()
    {
        $form = Builder::Form();

        $form->action('index.php')->method('post');

        $this->assertEquals('index.php', $form->attr('action'));
        $this->assertEquals('post', $form->attr('method'));
        $this->assertNull($form->getForm());

        return $form;
    }

    /**
     * @depends testBase
     */
    public function testFields(Form $form)
    {
        $form->add([
            'name' => Builder::text()->maxlength(50)->required()->label('Your name'),
            'email' => Builder::email()->required()->label('Your email'),
            'telephone' => Builder::tel()->required()->label('Telephone number'),
            'avatar' => Builder::file()->required()->label('Avatar'),

            'gender' => Builder::choose([
                'm' => Builder::radio()->label('Male'),
                'f' => Builder::radio()->required()->label('Female'),
            ]),

            'born' => Builder::group([
                'day' => Builder::number()->required()->min(1)->max(31)->label('Day'),
                'month' => Builder::number()->required()->min(1)->max(12)->label('Month'),
                'year' => Builder::number()->required()->min(1900)->max(2013)->label('Year'),
            ]),

            'language' => Builder::select()->required()->options(array(
                'gl' => 'Galician',
                'es' => 'Spanish',
                'en' => 'English',
            ))->label('Language'),

            'friends' => Builder::collection([
                'name' => Builder::text()->required()->label('Name'),
                'email' => Builder::email()->required()->label('email'),
                'age' => Builder::number()->required()->label('Age'),
            ]),

            'action' => Builder::choose([
                'save' => Builder::submit()->html('Save changes'),
                'duplicate' => Builder::submit()->html('Save as new value'),
            ]),
        ]);

        $this->assertCount(9, $form);

        $this->assertInstanceOf('FormManager\\Fields\\Text', $form['name']);
        $this->assertInstanceOf('FormManager\\Fields\\Submit', $form['action']['save']);

        $this->assertSame($form, $form['action']['save']->getForm());

        return $form;
    }

    /**
     * @depends testFields
     */
    public function testData($form)
    {
        $file = dirname(__DIR__).'/image.jpg';

        $data = array(
            'name' => 'Manuel',
            'email' => 'email@domain.com',
            'telephone' => '1234567890',
            'avatar' => array(
                'name' => 'image.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => $file,
                'size' => filesize($file),
                'error' => 0,
            ),
            'gender' => 'f',
            'born' => array(
                'day' => 23,
                'month' => 12,
                'year' => 2013,
            ),
            'language' => 'gl',
            'friends' => array(
                array(
                    'name' => 'Luis',
                    'email' => 'luis@luis.com',
                    'age' => 30,
                ),
            ),

            'action' => 'save',
        );

        $form->val($data);
        $this->assertTrue($form->isValid());
    }

    /**
     * @depends testFields
     */
    public function testLoad($form)
    {
        $file = dirname(__DIR__).'/image.jpg';

        $__files = array(
            'avatar' => array(
                'name' => 'image.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => $file,
                'size' => filesize($file),
                'error' => 0,
            ),
        );

        $__post = array(
            'name' => 'Manuel',
            'email' => 'email@domain.com',
            'telephone' => '1234567890',
            'gender' => 'f',
            'born' => array(
                'day' => 23,
                'month' => 12,
                'year' => 2013,
            ),
            'language' => 'gl',
            'friends' => array(
                array(
                    'name' => 'Luis',
                    'email' => 'luis@luis.com',
                    'age' => 30,
                ),
            ),

            'action' => 'save',
        );

        $form->loadFromGlobals(array(), $__post, $__files);

        $this->assertTrue($form->isValid());
    }

    /**
     * @depends testFields
     */
    public function testLoadPsr($form)
    {
        $file = dirname(__DIR__).'/image.jpg';

        $__files = array(
            'avatar' => new UploadedFile($file, filesize($file), 0, 'image.jpg', 'image/jpeg'),
        );

        $__post = array(
            'name' => 'Manuel',
            'email' => 'email@domain.com',
            'telephone' => '1234567890',
            'gender' => 'f',
            'born' => array(
                'day' => 23,
                'month' => 12,
                'year' => 2013,
            ),
            'language' => 'gl',
            'friends' => array(
                array(
                    'name' => 'Luis',
                    'email' => 'luis@luis.com',
                    'age' => 30,
                ),
            ),

            'action' => 'save',
        );

        $request = (new ServerRequest())
            ->withUploadedFiles($__files)
            ->withParsedBody($__post);

        $form->loadFromPsr7($request);
        $this->assertTrue($form->isValid());
    }

    public function testFieldsets()
    {
        $form = Builder::form([
                'submit' => Builder::submit(),
            ])->fieldsets([
                'personal' => [
                    'name' => Builder::text(),
                    'surname' => Builder::text(),
                    'age' => Builder::number(),
                ],
            ]);

        $this->assertCount(4, $form);
        $this->assertCount(1, $form->fieldsets());
        $this->assertCount(3, $form->fieldsets()['personal']);

        $form->clear()->add(['other' => Builder::text()]);

        $this->assertCount(1, $form);
    }
}
