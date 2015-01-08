<?php
use FormManager\Form;
use FormManager\Fields\Field;

include_once __DIR__.'/../src/autoloader.php';

class FormTest extends PHPUnit_Framework_TestCase
{
    public function testForm()
    {
        $form = new Form();

        $form->action('index.php')->method('post');

        $form->add([
            'name' => Field::text()->maxlength(50)->required()->label('Your name'),
            'email' => Field::email()->label('Your email'),
            'telephone' => Field::tel()->label('Telephone number'),

            'gender' => Field::choose([
                'm' => Field::radio()->label('Male'),
                'f' => Field::radio()->label('Female'),
            ]),

            'born' => Field::group([
                'day' => Field::number()->min(1)->max(31)->label('Day'),
                'month' => Field::number()->min(1)->max(12)->label('Month'),
                'year' => Field::number()->min(1900)->max(2013)->label('Year'),
            ]),

            'language' => Field::select()->options(array(
                'gl' => 'Galician',
                'es' => 'Spanish',
                'en' => 'English',
            ))->label('Language'),

            'friends' => Field::collection([
                'name' => Field::text()->label('Name'),
                'email' => Field::email()->label('email'),
                'age' => Field::number()->label('Age'),
            ]),

            'action' => Field::choose([
                'save' => Field::submit()->html('Save changes'),
                'duplicate' => Field::submit()->html('Save as new value'),
            ]),
        ]);

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

        $form->addValidator('myValidator', function ($form) {
            $val = $form['name']->val();

            return empty($val) ? true : 'The name value must be empty';
        });

        $this->assertFalse($form->isValid());
        $this->assertEquals('The name value must be empty', $form->error());
    }
}
