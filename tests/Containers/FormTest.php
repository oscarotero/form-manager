<?php
use FormManager\Builder;
use FormManager\Containers\Form;
use FormManager\InvalidValueException;

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
            'email' => Builder::email()->label('Your email'),
            'telephone' => Builder::tel()->label('Telephone number'),

            'gender' => Builder::choose([
                'm' => Builder::radio()->label('Male'),
                'f' => Builder::radio()->label('Female'),
            ]),

            'born' => Builder::group([
                'day' => Builder::number()->min(1)->max(31)->label('Day'),
                'month' => Builder::number()->min(1)->max(12)->label('Month'),
                'year' => Builder::number()->min(1900)->max(2013)->label('Year'),
            ]),

            'language' => Builder::select()->options(array(
                'gl' => 'Galician',
                'es' => 'Spanish',
                'en' => 'English',
            ))->label('Language'),

            'friends' => Builder::collection([
                'name' => Builder::text()->label('Name'),
                'email' => Builder::email()->label('email'),
                'age' => Builder::number()->label('Age'),
            ]),

            'action' => Builder::choose([
                'save' => Builder::submit()->html('Save changes'),
                'duplicate' => Builder::submit()->html('Save as new value'),
            ]),
        ]);

        $this->assertCount(8, $form);

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
        $data = array(
            'name' => 'Manuel',
            'email' => null,
            'telephone' => null,
            'gender' => 'm',
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

        $form->addValidator(function ($form) {
            if ($form['name']->val()) {
                throw new InvalidValueException('The name value must be empty');
            }
        });

        $this->assertFalse($form->isValid());
        $this->assertEquals('The name value must be empty', $form->error());
    }
}
