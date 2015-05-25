<?php
use FormManager\Builder;
use FormManager\Containers\Collection;

class CollectionTest extends BaseTest
{
    public function testBase()
    {
        $field = Builder::collection([
            'name' => Builder::text()->label('Name'),
            'email' => Builder::email()->label('email'),
            'age' => Builder::number()->label('Age'),
            'image' => Builder::file()->label('Image'),
        ]);

        $this->assertInstanceOf('FormManager\\Containers\\Collection', $field);
        $this->assertInstanceOf('FormManager\\Containers\\Group', $field->template);

        return $field;
    }

    /**
     * @depends testBase
     */
    public function testValue(Collection $field)
    {
        $field->val([
            [
                'name' => 'Oscar',
                'email' => 'oscar@email.com',
                'age' => '35',
                'image' => [
                    'name' => '1.png',
                    'type' => 'image/png',
                    'tmp_name' => '/tmp/phpTobJ71',
                    'error' => 0,
                    'size' => 2297,
                ],
            ], [
                'name' => 'Laura',
                'email' => 'laura@email.com',
                'age' => '35',
                'image' => [
                    'name' => '2.png',
                    'type' => 'image/png',
                    'tmp_name' => '/tmp/phpTobJ72',
                    'error' => 0,
                    'size' => 2297,
                ],
            ],
        ]);

        $this->assertCount(2, $field->val());
        $this->assertEquals('Laura', $field[1]['name']->val());
        $this->assertEquals('2.png', $field[1]['image']->val()['name']);

        return $field;
    }

    /**
     * @depends testValue
     */
    public function testTemplate(Collection $field)
    {
        $form = Builder::form();
        $form['key'] = $field;
        $template = $field->getTemplate();
        $template['name']->id('my-id');
        $template['name']->label->id('my-label-id');

        $this->assertEquals('<label id="my-label-id" for="my-id">Name</label> <input type="text" id="my-id" name="key[::n::][name]" aria-labelledby="my-label-id"> ', (string) $template['name']);
    }
}
