<?php
use FormManager\Fields\Field;
use FormManager\Fields\CollectionMultiple;

class CollectionMultipleTest extends BaseTest
{
    public function testBase()
    {
        $field = Field::collectionMultiple([
            'section' => [
                'title' => Field::text()->label('Title'),
                'text' => Field::textarea()->label('Text'),
            ],
            'picture' => [
                'caption' => Field::text()->label('Caption'),
                'image' => Field::file()->label('Image'),
            ],
            'quote' => [
                'cite' => Field::textarea()->label('Cite'),
                'author' => Field::text()->label('Author'),
            ],
        ]);

        $this->assertInstanceOf('FormManager\\Fields\\CollectionMultiple', $field);
        $this->assertInstanceOf('FormManager\\Fields\\Group', $field->fields['section']);
        $this->assertInstanceOf('FormManager\\Label', $field->label);

        return $field;
    }

    /**
     * @depends testBase
     */
    public function testValue(CollectionMultiple $field)
    {
        $field->val([
            [
                'type' => 'section',
                'title' => 'This is a title',
                'text' => 'This is a text',
            ], [
                'type' => 'picture',
                'caption' => 'This is the caption',
                'image' => [
                    'name' => '1.png',
                    'type' => 'image/png',
                    'tmp_name' => '/tmp/phpTobJ71',
                    'error' => 0,
                    'size' => 2297,
                ],
            ], [
                'type' => 'quote',
                'cite' => 'This is the cite',
                'author' => 'This is the author of the cite',
            ], [
                'type' => 'section',
                'title' => 'This is other section',
                'text' => 'This is the text of the second section',
            ],
        ]);

        $this->assertCount(4, $field->val());
        $this->assertEquals('This is a title', $field[0]['title']->val());
        $this->assertEquals('This is the cite', $field[2]['cite']->val());
    }
}
